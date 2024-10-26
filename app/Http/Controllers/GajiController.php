<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Divisi;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gaji = Gaji::select('periode_awal', 'periode_akhir')
        ->distinct()
        ->get();
        return view('master.gaji.index', compact('gaji'));
    }
    public function list($awal, $akhir)
    {
        $gaji = Gaji::where('periode_awal', $awal)
        ->where('periode_akhir', $akhir)
        ->get();
        return view('master.gaji.list', compact('gaji'));
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
        $gaji = new Gaji();
        $gaji->karyawan_nip = $request->nip;
        $gaji->total_gaji = $request->total_gaji;
        $gaji->periode_awal = $request->periode_awal;
        $gaji->periode_akhir = $request->periode_akhir;
        $gaji->save();
        return redirect()->back()->with(['success' => 'Berhasil Melakukan Pembayaran']);
    }

    /**
     * Display the specified resource.
     */
    public function show($tahun, $minggu, Gaji $gaji)
    {
        $absensi = Absensi::where('karyawan_nip', $gaji->karyawan_nip)
        ->whereBetween('tanggal_kerja', [$gaji->periode_awal, $gaji->periode_akhir])
        ->get();
        $karyawan = Karyawan::findOrFail($gaji->karyawan_nip);
        return view('master.gaji.show', compact('tahun','minggu','gaji','absensi', 'karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gaji $gaji)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gaji $gaji)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gaji $gaji)
    {
        //
    }
}
