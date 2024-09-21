<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $fillable = [
        'nip',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'divisi_id',
        'no_hp',
        'user_id'
    ];
    public function divisi(){
        return $this->belongsTo(Divisi::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
