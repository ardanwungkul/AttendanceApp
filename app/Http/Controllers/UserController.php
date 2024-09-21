<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::where('role', 'karyawan')->get();
        return view('master.user.index', compact('user'));
    }
}
