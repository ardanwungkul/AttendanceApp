<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('master.user.create');
    }
    public function edit(User $pengguna)
    {
        return view('master.user.edit', compact('pengguna'));
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
        return redirect()->route('pengguna.index')->with(['success' => 'Berhasil Mengubah Divisi']);
    }
    public function destroy(User $pengguna)
    {
        $pengguna->delete();
        return redirect()->back();
    }
}
