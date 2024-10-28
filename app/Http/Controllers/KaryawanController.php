<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Divisi;
use App\Models\Absensi;
use App\Models\Gaji;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan = Karyawan::with('divisi', 'user')->get();
        return view('master.karyawan.index', compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisi = Divisi::all();
        return view('master.karyawan.create', compact('divisi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'divisi_id' => 'required|exists:divisis,id',
            'no_hp' => 'required|string|max:15',
        ]);

        $newUser = User::create([
            'username' => $this->getUserName($request->nama_lengkap),
            'role' => 'karyawan',
            'password' => Hash::make($request->tanggal_lahir),
        ]);
        $newUser->save();
        $nip = IdGenerator::generate(['table' => 'karyawans', 'field' => 'nip', 'length' => 9, 'prefix' => date('ym')]);
        Karyawan::create([
            'nip' => $nip,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'divisi_id' => $request->divisi_id,
            'no_hp' => $request->no_hp,
            'user_id' => $newUser->id,
            'no_rekening' => $request->no_rekening
        ]);

        // Redirect ke halaman yang diinginkan dengan pesan sukses
        return redirect()->route('karyawan.index')->with(['success', 'Karyawan berhasil ditambahkan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        // Mengambil semua absensi berdasarkan karyawan_nip
        $absensi = Absensi::where('karyawan_nip', $karyawan->nip)->get();

        // Mengelompokkan data absensi berdasarkan tahun dan periode minggu kerja
        $groupedAbsensi = $absensi->groupBy(function ($item) {
            $tanggal = Carbon::parse($item->tanggal_kerja);
            $tahun = $tanggal->format('Y'); // Tahun
            // Menghitung minggu kerja
            $firstDayOfYear = Carbon::createFromFormat('Y-m-d', "$tahun-01-01");
            $firstMondayOfYear = $firstDayOfYear->copy()->startOfWeek(); // Mendapatkan hari Senin pertama tahun
            $weekOfYear = $tanggal->diffInWeeks($firstMondayOfYear) + 1; // Menambahkan 1 agar mulai dari minggu 1

            return $tahun . '-Minggu-' . $weekOfYear; // Format key: "2024-Minggu-1"
        });

        // Menyiapkan rentang tanggal untuk setiap minggu dan menambahkan statusGaji
        $rentangTanggal = [];
        foreach ($groupedAbsensi as $key => $items) {
            // Mengambil tahun dan minggu dari key
            list($tahun, $minggu) = explode('-Minggu-', $key);
            $weekNumber = (int)$minggu;

            // Menghitung tanggal awal dan akhir minggu
            $firstDayOfYear = Carbon::createFromFormat('Y-m-d', "$tahun-01-01");
            $firstMondayOfYear = $firstDayOfYear->copy()->startOfWeek(); // Mendapatkan hari Senin pertama tahun
            $startDate = $firstMondayOfYear->copy()->addWeeks($weekNumber - 1); // Tanggal mulai minggu
            $endDate = $startDate->copy()->addDays(4); // Tanggal akhir minggu

            // Menyimpan rentang tanggal
            $rentangTanggal[$key] = $startDate->format('d F') . ' s/d ' . $endDate->format('d F Y');

            // Mengecek apakah gaji sudah dibayarkan dalam rentang tanggal ini
            $gaji = Gaji::where('karyawan_nip', $karyawan->nip)
                ->where('periode_awal',  $startDate->format('Y-m-d'))
                ->where('periode_akhir',  $endDate->format('Y-m-d'))
                ->exists(); // Mengembalikan true jika gaji ada dalam rentang tanggal
            // Menambahkan statusGaji pada groupedAbsensi
            $groupedAbsensi[$key]->statusGaji = $gaji ? true : false;
        }

        return view('master.karyawan.show', compact('karyawan', 'groupedAbsensi', 'rentangTanggal'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $divisi = Divisi::all();
        return view('master.karyawan.edit', compact('karyawan', 'divisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'divisi_id' => 'required|exists:divisis,id',
            'no_hp' => 'required|string|max:15',
        ]);

        $karyawan->update([
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'divisi_id' => $request->divisi_id,
            'no_hp' => $request->no_hp,
            'no_rekening' => $request->no_rekening
        ]);

        return redirect()->route('karyawan.index')->with(['success', 'Data karyawan berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $user = $karyawan->user();
        $user->delete();
        return redirect()->route('karyawan.index')->with(['success', 'Data karyawan berhasil Dihapus.']);
    }

    public function getUserName($name)
    {
        $nameParts = explode(' ', $name);
        if (count($nameParts) >= 2) {
            $username = strtolower($nameParts[0] . $nameParts[1]);
        } else {
            $username = strtolower($nameParts[0]);
        }
        $originalUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }
        return $username;
    }
}
