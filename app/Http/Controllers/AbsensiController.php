<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Iroid\LaravelHaversine\Haversine;
use Yajra\DataTables\DataTables;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $idUser = Auth::user()->id;
        $karyawan = Karyawan::where('user_id', $idUser)->first();

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
        if ($request->ajax()) {
            return DataTables::of($groupedAbsensi)
                ->addIndexColumn()
                ->make(true);
        }

        // Mengembalikan bulan, tahun, periode minggu, dan rentang tanggal
        return view('master.absensi.index', compact('groupedAbsensi', 'rentangTanggal'));
    }

    /**
     * Store a newly created resource in storage.
     */

    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($lat1) * cos($lat2) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
    public function store(Request $request)
    {
        $pengaturan = Pengaturan::first();

        if ($request->tipe == 'check_in') {
            $absensi = new Absensi();
            $absensi->tanggal_kerja = Carbon::today();
            $absensi->karyawan_nip = $request->nip;
            $absensi->status = $request->status;
            if ($request->status == 'tidak hadir') {
                $absensi->keterangan = $request->keterangan;
                if ($request->hasFile('lampiran')) {
                    $file = $request->file('lampiran');
                    $fileName = time() . '_' . Auth::user()->id . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('storage/lampiran'), $fileName);
                    $absensi->lampiran = $fileName;
                }
            } else {
                $latitudeUser = floatval($request->latitude);
                $longitudeUser = floatval($request->longitude);
                $latitudePengaturan = floatval($pengaturan->latitude);
                $longitudePengaturan = floatval($pengaturan->longitude);
                $distance = $this->haversine(
                    $latitudePengaturan,
                    $longitudePengaturan,
                    $latitudeUser,
                    $longitudeUser
                );
                if ($distance <= $pengaturan->radius) {
                    $absensi->jam_masuk = Carbon::now()->format('H:i:s');
                } else {
                    return redirect()->back()->withErrors('Anda berada di luar area absensi.');
                }
            }
            $absensi->save();
            return redirect()->back()->with(['success' => 'Berhasil Melakukan Absensi']);
        } else {
            $absensi = Absensi::find($request->absensi_id);
            $absensi->jam_keluar = Carbon::now()->format('H:i:s');
            if (Carbon::now()->greaterThan(Carbon::createFromFormat('H:i:s', $pengaturan->jam_keluar))) {
                if (Carbon::parse($absensi->jam_masuk)->greaterThan(Carbon::createFromFormat('H:i:s', $pengaturan->jam_masuk))) {
                    $absensi->keterangan = 'Datang Terlambat';
                } else {
                    $absensi->keterangan = 'Tepat Waktu';
                }
            } else {
                if (Carbon::parse($absensi->jam_masuk)->greaterThan(Carbon::createFromFormat('H:i:s', $pengaturan->jam_masuk))) {
                    $absensi->keterangan = 'Pulang Lebih Awal dan Terlambat';
                } else {
                    $absensi->keterangan = 'Pulang Lebih Awal';
                }
            }
            $absensi->save();
            return redirect()->back()->with(['success' => 'Berhasil Melakukan Absensi']);
        }
    }

    public function show($nip, $tahun, $minggu)
    {
        // Mendapatkan ID user yang sedang login
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin') {
            $karyawan = Karyawan::where('nip', $nip)->first();
        } else {
            $idUser = Auth::user()->id;
            $karyawan = Karyawan::where('user_id', $idUser)->first();
            $nip = $karyawan->nip;
        }

        // Menghitung tanggal awal dari minggu yang diminta
        // Mendapatkan hari Senin pertama dari tahun yang diberikan
        $firstDayOfYear = Carbon::createFromFormat('Y-m-d', "$tahun-01-01");
        $firstMondayOfYear = $firstDayOfYear->copy()->startOfWeek(); // Mendapatkan hari Senin pertama tahun

        // Menentukan tanggal mulai dan akhir dari minggu yang diminta
        $startDate = $firstMondayOfYear->copy()->addWeeks($minggu - 1); // Tanggal mulai minggu yang diminta
        $endDate = $startDate->copy()->endOfWeek(); // Tanggal akhir minggu

        // Mengambil data absensi yang sesuai dengan karyawan_nip dan rentang tanggal
        $absensi = Absensi::where('karyawan_nip', $karyawan->nip)
            ->whereBetween('tanggal_kerja', [$startDate, $endDate])
            ->get();
        $gaji = Gaji::where('karyawan_nip', $karyawan->nip)
            ->where('periode_awal', $startDate->format('Y-m-d'))
            ->where('periode_akhir', $endDate->subDays(2)->format('Y-m-d'))
            ->first();
        // Mengembsalikan view dengan data absensi yang diambil
        return view('master.absensi.show', compact('absensi', 'tahun', 'minggu', 'startDate', 'endDate', 'karyawan', 'gaji'));
    }
    public function download(Absensi $absensi)
    {
        $path = public_path('storage/lampiran/' . $absensi->lampiran);

        if (File::exists($path)) {
            return Response::download($path);
        } else {
            return abort(404, 'File not found.');
        }
    }
}
