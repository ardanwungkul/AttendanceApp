<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make(12345678)
        ]);

        User::create([
            'username' => 'superadmin',
            'role' => 'superadmin',
            'password' => Hash::make(12345678)
        ]);
        User::create([
            'username' => 'karyawan',
            'role' => 'karyawan',
            'password' => Hash::make(12345678)
        ]);
        Divisi::create([
            'nama_divisi' => 'Manajer'
        ]);
    }
}
