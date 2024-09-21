<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
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
        $karyawan = Karyawan::with('divisi','user')->get();
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
        $nip =IdGenerator::generate(['table' => 'karyawans', 'field'=>'nip', 'length' => 9, 'prefix' => date('ym')]);
        // dd($nip);
        Karyawan::create([
            'nip' => $nip ,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'divisi_id' => $request->divisi_id,
            'no_hp' => $request->no_hp,
            'user_id' => $newUser->id
        ]);

        // Redirect ke halaman yang diinginkan dengan pesan sukses
        return redirect()->route('karyawan.index')->with(['success', 'Karyawan berhasil ditambahkan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
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
