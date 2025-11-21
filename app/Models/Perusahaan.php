<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;
    protected $table = 'perusahaan';

    protected $fillable = [
        'perusahaan_nama',
        'perusahaan_npwp',
        'perusahaan_nib'

    ];
}
