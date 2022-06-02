<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_type',
        'device_brand',
        'device_model',
        'user_note',
        'name',
        'national_id',
        'tel',
        'province_id',
        'city_id',
        'address',
        'lat',
        'lon',
    ];
}
