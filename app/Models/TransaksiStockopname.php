<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiStockopname extends Model
{
    use HasFactory;

    protected $table = 'transaksi_stockopname';

    protected $fillable = [
        'transaksi_nomor',
        'transaksi_ket'

    ];
}
