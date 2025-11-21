<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPengeluaran extends Model
{
    use HasFactory;
    protected $table = 'transaksi_pengeluaran';

    protected $fillable = [
        'transaksi_nomor',
        'transaksi_ket'

    ];
}
