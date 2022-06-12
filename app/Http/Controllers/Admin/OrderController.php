<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateReq;
use App\Http\Requests\OrderMetaCreateReq;
use App\Http\Requests\OrderUpdateReq;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderMeta;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $perPage = request()->get('perPage', 30);
        return  app('res')->success(
            new OrderCollection(Order::orderBy('id', 'DESC')->paginate($perPage)),
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
        if ($order = Order::create($data))
            return app('res')->success(new OrderResource($order));
        else
            return app('res')->error('error while saving order');
    }

    public function update(OrderUpdateReq $request, Order $order)
    {
        $data = $request->validated();

        $order->rough_price = $data['rough_price'] ?? null;
        $order->requested_price = $data['requested_price'] ?? null;
        $order->final_price = $data['final_price'] ?? null;
        $order->admin_note = $data['admin_note'] ?? null;
        $order->status = $data['status'] ?? $order->status;
        $order->device_type = $data['device_type'] ?? $order->device_type;
        $order->device_brand = $data['device_brand'] ?? $order->device_brand;
        $order->device_model = $data['device_model'] ?? $order->device_model;
        $order->name = $data['name'] ?? $order->name;
        $order->address = $data['address'] ?? $order->address;
        if ($order->save())
            return app('res')->success(new OrderResource($order), 'Order updated successfully.');
        return app('res')->error('error while updating order');
    }

    public function addNote(OrderMetaCreateReq $request, Order $order)
    {
        $orderMeta = new OrderMeta();
        $orderMeta->order_id = $order->id;
        $orderMeta->user_id = auth('sanctum')->user()->id;
        $orderMeta->name = 'note';
        $orderMeta->value = $request->get('value');
        if ($orderMeta->save())
            return app('res')->success($orderMeta, 'Note added successfully.');
    }

    public function getNotes(Order $order)
    {
        return app('res')->success(
            OrderMeta::where('order_id', $order->id)->where('name', 'note')->orderBy('id', 'DESC')->get()
        );
    }
}
