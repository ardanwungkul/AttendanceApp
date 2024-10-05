<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

    // Menyiapkan rentang tanggal untuk setiap minggu
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
    }

    // Mengembalikan bulan, tahun, periode minggu, dan rentang tanggal
    return view('master.absensi.index', compact('groupedAbsensi', 'rentangTanggal'));
}





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show($tahun, $minggu)
{
    // Mendapatkan ID user yang sedang login
    $idUser = Auth::user()->id;

    // Mencari karyawan berdasarkan user_id
    $karyawan = Karyawan::where('user_id', $idUser)->first();

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

    // Mengembalikan view dengan data absensi yang diambil
    return view('master.absensi.show', compact('absensi', 'tahun', 'minggu'));
}




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        //
    }
}
