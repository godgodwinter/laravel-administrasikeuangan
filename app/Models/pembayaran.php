<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaran extends Model
{
    public $table = "pembayaran";

    use HasFactory;

    protected $fillable = [
        'siswa_nama',
        'siswa_nis',
        'namatagihan',
        'nominaltagihan',
        'tipe',
        'semester',
        'tapel_nama',
        'bln',
    ];
}
