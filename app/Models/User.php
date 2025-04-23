<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tempat_tanggal_lahir',
        'tanggal_diangkat',
        'gaji_pokok',
        'tunjangan_makan',
        'tunjangan_hari_tua',
        'tunjangan_retar',
        'jumlah_kotor',
        'potongan_BPJS',
        'potongan_tabungan_hari_tua',
        'potongan_kredit_kasbon',
        'jumlah_bersih',
        'ttd'
    ];
}
