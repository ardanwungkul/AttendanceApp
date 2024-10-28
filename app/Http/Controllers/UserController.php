<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $pengguna = User::whereNot('role', 'superadmin')->get();
        return view('master.user.index', compact('pengguna'));
    }
    public function create()
    {
        $divisi = Divisi::all();
        return view('master.user.create', compact('divisi'));
    }
    public function edit(User $pengguna)
    {
        $divisi = Divisi::all();
        return view('master.user.edit', compact('pengguna', 'divisi'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required'
        ]);

        $pengguna = new User();
        $pengguna->username = $request->username;
        $pengguna->password = Hash::make($request->password);
        $pengguna->role = $request->role;
        $pengguna->save();
        if ($request->role == 'karyawan') {
            $nip = IdGenerator::generate(['table' => 'karyawans', 'field' => 'nip', 'length' => 9, 'prefix' => date('ym')]);
            Karyawan::create([
                'nip' => $nip,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'divisi_id' => $request->divisi_id,
                'no_hp' => $request->no_hp,
                'user_id' => $pengguna->id
            ]);
        }
        return redirect()->route('pengguna.index')->with(['success' => 'Berhasil Menambahkan Pengguna']);
    }
    public function update(Request $request, User $pengguna)
    {
        $request->validate([
            'username' => [
                'required',
                Rule::unique('users')->ignore($pengguna->id),
            ],
        ]);


        $pengguna->username = $request->username;
        if ($request->has('password') && $request->password !== null) {
            $pengguna->password = Hash::make($request->password);
        }
        $pengguna->save();
        if ($pengguna->role == 'karyawan') {
            $pengguna->karyawan->update([
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'divisi_id' => $request->divisi_id,
                'no_hp' => $request->no_hp,
            ]);
        }
        return redirect()->route('pengguna.index')->with(['success' => 'Berhasil Mengubah Pengguna']);
    }
    public function destroy(User $pengguna)
    {
        $pengguna->delete();
        return redirect()->back();
    }
}
