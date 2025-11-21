<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPemasukan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pemasukan';

    protected $fillable = [
        'transaksi_nomor',
        'transaksi_ket'

    ];
}
