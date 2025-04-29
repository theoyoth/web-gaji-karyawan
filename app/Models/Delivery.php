<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
      'salary_id',
      'kota',
      'jumlah_retase',
      'tarif_retase',
      'jumlah_ur',

    ];

  public function salary() {
    return $this->belongsTo(Salary::class);
  }
}
