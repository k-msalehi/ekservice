<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','amount'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
        if (isset($data['order_id'])) {
            $query->where('order_id', $data['order_id']);
        }
        if (isset($data['user_id'])) {
            $query->where('user_id', $data['user_id']);
        }

        return $query;
    }
}
