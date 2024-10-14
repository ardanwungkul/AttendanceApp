<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengaturan = Pengaturan::first();
        return view('master.pengaturan', compact('pengaturan'));
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
        $pengaturan = Pengaturan::first();
        $pengaturan->jam_masuk = $request->jam_masuk;
        $pengaturan->jam_keluar = $request->jam_keluar;
        $pengaturan->batas_waktu = $request->batas_waktu;
        $pengaturan->latitude = $request->latitude;
        $pengaturan->longitude = $request->longitude;
        $pengaturan->radius = $request->radius;
        $pengaturan->save();
        return redirect()->back()->with(['success' => 'Berhasil Menyimpan Pengaturan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaturan $pengaturan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaturan $pengaturan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaturan $pengaturan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaturan $pengaturan)
    {
        //
    }
}
