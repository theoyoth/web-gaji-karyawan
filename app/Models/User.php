<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal_diangkat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_diangkat' => 'date',
    ];

    public function salaries(){
        return $this->hasMany(Salary::class);
    }
}
