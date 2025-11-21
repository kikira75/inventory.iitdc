<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'assets_id',
        'document_type',
        'registration_number',
        'registration_date',
        'expense_number',
        'dispensing_date',
        'item_code',
        'item_category',
        'item_name',
        'item_unit',
        'item_quantity',
        'entry_status',
        'status_sending',
        'datetime_sending'
    ];

    protected $guarded = [
        'assets_id'
    ];
}
