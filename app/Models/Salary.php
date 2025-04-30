<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'year',
        'gaji_pokok',
        'hari_kerja',
        'tunjangan_makan',
        'tunjangan_hari_tua',
        'potongan_bpjs',
        'potongan_tabungan_hari_tua',
        'potongan_kredit_kasbon',
        'jumlah_bersih',
        'ttd',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function deliveries() {
      return $this->hasMany(Delivery::class);
    }

}
