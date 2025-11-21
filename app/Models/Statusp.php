<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statusp extends Model
{
    use HasFactory;

    protected $table = 'statusp';

    protected $fillable = ['nama_status'];

    public $timestamps = true;
}
