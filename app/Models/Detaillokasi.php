<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detaillokasi extends Model
{
    use HasFactory;

    protected $table = 'detaillokasi';

    protected $fillable = ['id', 'detail_lokasi'];

}
