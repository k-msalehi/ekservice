<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateReq;
use App\Models\Order;
use App\Rules\IrMobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function create(OrderCreateReq $request)
    {
        $order = new Order();
        
    }
}
