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
        'province_id',
        'city_id',
        'address',
        'status',
        'lat',
        'lon',
    ];

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case config('constants.order.status.submited'):
                return 'ثبت اولیه';
            case config('constants.order.status.deliverySent1'):
                return 'درحال دریافت کالا از مشتری';
            case config('constants.order.status.pickedByDelivery1'):
                return 'دریافت محصول توسط پیک';
            case config('constants.order.status.pickedByHead'):
                return 'دریافت محصول توسط مرکز';
            case config('constants.order.status.debugging'):
                return 'درحال عیب یابی';
            case config('constants.order.status.debugging'):
                return 'درحال عیب یابی';
            case config('constants.order.status.waitingForCustomerConfirm'):
                return 'منتظر تایید مشتری';

            default:
                return 'نامشخص';
        }
    }
}
