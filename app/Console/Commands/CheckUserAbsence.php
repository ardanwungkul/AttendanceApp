<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckUserAbsence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:user-absence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check user absence and mark as "Tidak Hadir" if no absence record exists for the day';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $today = Carbon::now();
        if (!$today->isWeekend()) {
            $users = Karyawan::all();
            foreach ($users as $user) {
                $hasAbsence = Absensi::where('karyawan_nip', $user->nip)
                    ->whereDate('tanggal_kerja', $today->toDateString())
                    ->exists();

                if (!$hasAbsence) {
                    $absensi = new Absensi();
                    $absensi->tanggal_kerja = Carbon::today();
                    $absensi->karyawan_nip = $user->nip;
                    $absensi->status = 'tidak hadir';
                    $absensi->keterangan = 'tidak melakukan absen sebelum jam yang telah di tentukan';
                    $absensi->save();
                }
            }
        }

        return Command::SUCCESS;
    }
}
