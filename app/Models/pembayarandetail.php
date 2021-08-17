<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayarandetail extends Model
{
    public $table = "pembayarandetail";

    use HasFactory;

    protected $fillable = [
        'pembayaran_id',
        'nominal',
        'tglbayar',
        'bln',
    ];
}
