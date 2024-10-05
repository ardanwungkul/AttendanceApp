<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Divisi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


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

        DB::table('karyawans')->insert([
            'nip' => '123',
            'nama_lengkap' => 'Budi Santoso',
            'jenis_kelamin' => 'Laki Laki',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => Carbon::create('1990', '01', '15'), // Format Y-m-d
            'divisi_id' => 1,
            'user_id' => 3,
            'no_hp' => '081234567890',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('absensis')->insert([
            [
                'tanggal_kerja' => Carbon::today(),
                'jam_masuk' => Carbon::createFromTime(8, 30, 0), // Jam masuk: 08:30:00
                'jam_keluar' => Carbon::createFromTime(17, 0, 0), // Jam keluar: 17:00:00
                'keterangan' => 'Tepat waktu',
                'status' => 'hadir',
                'karyawan_nip' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tanggal_kerja' => Carbon::yesterday(),
                'jam_masuk' => Carbon::createFromTime(9, 0, 0), // Jam masuk: 09:00:00
                'jam_keluar' => Carbon::createFromTime(17, 30, 0), // Jam keluar: 17:30:00
                'keterangan' => 'Terlambat masuk',
                'status' => 'hadir',
                'karyawan_nip' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tanggal_kerja' => Carbon::now()->subDays(2),
                'jam_masuk' => null, // Tidak hadir
                'jam_keluar' => null, // Tidak hadir
                'keterangan' => 'Sakit',
                'status' => 'tidak hadir',
                'karyawan_nip' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
