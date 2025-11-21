<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiAdjusment extends Model
{
    use HasFactory;
    protected $table = 'transaksi_adjusment';

    protected $fillable = [
        'transaksi_nomor',
        'transaksi_ket'

    ];
}
