<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateReq;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Rules\IrMobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $perPage = request()->get('perPage', 30);
        // return OrderResource::collection(Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(30));
        return  app('res')->success(
            new OrderCollection(Order::where('user_id', auth('sanctum')->user()->id)->orderBy('id', 'DESC')->paginate($perPage)),
            'Orders fetched successfully.'
        );
    }

    public function show(Order $order)
    {
        return app('res')->success(new OrderResource($order));
    }
    public function store(OrderCreateReq $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth('sanctum')->user()->id;
        $data['status'] = config('constants.order.status.submitted');
        if ($order = Order::create($data))
            return app('res')->success(new OrderResource($order), 'Order created successfully.');
        else
            return app('res')->error('error while saving order');
    }

    public function cancel(Order $order)
    {
        $order->status = config('constants.order.status.cancelRequestByCustomer');
        $order->save();
        return app('res')->success(new OrderResource($order), 'Order cancel request sent successfully.');

    }
}
