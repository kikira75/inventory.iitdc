<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPeng extends Model
{
    use HasFactory;

    protected $table = 'jenispeng';

    protected $fillable = ['id', 'nama_jenis'];

    public $timestamps = false;
}
