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

        // Mengelompokkan data absensi berdasarkan bulan, tahun, dan periode minggu
        $groupedAbsensi = $absensi->groupBy(function($item) {
            $tanggal = Carbon::parse($item->tanggal_kerja);
            $bulan = $tanggal->format('F'); // Nama bulan (misalnya: January)
            $tahun = $tanggal->format('Y'); // Tahun
            $mingguKe = $tanggal->weekOfMonth;   // Periode minggu dalam bulan
            return $tahun . '-' . $bulan . '-Minggu-' . $mingguKe; // Format key: "2024-January-Minggu-1"
        });

        // Mengembalikan bulan, tahun, dan periode minggu
        return view('master.absensi.index', compact('groupedAbsensi'));
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

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        //
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
