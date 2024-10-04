<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'currency_code',
        'active',
        'max_discount',
        'max_usage',
        'current_usage',
        'description'
    ];
}
