<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisi = Divisi::all();
        return view('master.divisi.index', compact('divisi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.divisi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|unique:divisis',
            'upah_per_hari' => 'required',
        ]);
        $divisi = new Divisi();
        $divisi->nama_divisi = $request->nama_divisi;
        $divisi->upah_per_hari = $request->upah_per_hari;
        $divisi->save();
        return redirect()->route('divisi.index')->with(['success' => 'Berhasil Menambahkan Divisi']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Divisi $divisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Divisi $divisi)
    {
        return view('master.divisi.edit', compact('divisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Divisi $divisi)
    {
        $request->validate([
            'nama_divisi' => [
                'required',
                Rule::unique('divisis')->ignore($divisi->id),
            ],
            'upah_per_hari' => 'required',
        ]);
        $divisi->nama_divisi = $request->nama_divisi;
        $divisi->upah_per_hari = $request->upah_per_hari;
        $divisi->save();
        return redirect()->route('divisi.index')->with(['success' => 'Berhasil Mengubah Divisi']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Divisi $divisi)
    {
        $divisi->delete();
        return redirect()->route('divisi.index')->with(['success' => 'Berhasil Menghapus Divisi']);
    }
}
