<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class peminjamanLaptop extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'nama',
        'nis',
        'rombel',
        'rayon',
        'tanggal_peminjaman',
        'no_laptop',
    ];
}
