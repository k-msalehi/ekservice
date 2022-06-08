<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateReq;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Rules\IrMobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        return OrderResource::collection(Order::where('user_id', auth()->user()->id)->orderBy('id','DESC')->get());
    }

    public function show(Order $order)
    {
        if ($order)
            return app('res')->success(new OrderResource($order));
        else
            return app('res')->error('Order not found', 404);
    }
    public function store(OrderCreateReq $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        if ($order = Order::create($data))
            return app('res')->success(new OrderResource($order));
        else
            return app('res')->error('error while saving order');
    }
}
