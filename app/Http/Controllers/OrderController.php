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
            new OrderCollection(Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate($perPage)),
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
        $data['user_id'] = auth()->user()->id;
        $data['status'] = config('constants.order.status.submited');
        if ($order = Order::create($data))
            return app('res')->success(new OrderResource($order));
        else
            return app('res')->error('error while saving order');
    }
}
