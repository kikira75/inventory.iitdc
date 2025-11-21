<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeDokumen extends Model
{
    use HasFactory;

    protected $table = 'kode_dokumen';

    protected $fillable = ['kode', 'label'];
    protected $primaryKey = 'id_dokumen';
    public $timestamps = false;
}
