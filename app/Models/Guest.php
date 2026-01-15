<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'nama',
        'instansi',
        'telepon',
        'bidang',   // Tambahkan baris ini
        'keperluan',
    ]; 
}