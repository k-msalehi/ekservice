<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id', 'id');
    }
    
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case config('constants.order.status.submitted'):
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
            case config('constants.order.status.fixing'):
                return 'در حال تعمیر';
            case config('constants.order.status.cannotFix'):
                return 'غیرقابل تعمیر';
            case config('constants.order.status.fixed'):
                return 'تعمیر شده';
            case config('constants.order.status.deliverySent2'):
                return 'در حال تحویل کالا از مشتری';
            case config('constants.order.status.completed'):
                return 'تکمیل موفق';
            case config('constants.order.status.autocanceled'):
                return 'لغو خودکار';
            case config('constants.order.status.cancelRequestByCustomer'):
                return 'درخواست لغو از مشتری';
            case config('constants.order.status.canceledByCustomer'):
                return 'لغو توسط مشتری';
            case config('constants.order.status.canceledByHead'):
                return 'لغو توسط مرکز';

            default:
                return 'نامشخص';
        }
    }

    public function meta()
    {
        return $this->hasMany(OrderMeta::class, 'order_id', 'id');
    }

    public function scopeFilter($query, $data)
    {
        if (isset($data['id'])) {
            $query->where('id', $data['id']);
            return $query;
        }
        if (isset($data['status'])) {
            $query->where('status', $data['status']);
        }
        if (isset($data['device_type'])) {
            $query->where('device_type', $data['device_type']);
        }
        if (isset($data['device_brand'])) {
            $query->where('device_brand', $data['device_brand']);
        }

        if (isset($data['user_id'])) {
            $query->where('user_id', $data['user_id']);
        }

        return $query;
    }
}
