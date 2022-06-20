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
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 25);
        return  app('res')->success(
            new OrderCollection(Order::filter(request()->all())->orderBy('id', 'DESC')->paginate($perPage)),
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
        $note = '';
        if ($order->rough_price != $request->get('rough_price') && $request->get('rough_price')) {
            $oldPrice = $order->rough_price ?? 'بدون قیمت';
            $note .= 'قیمت حدودی از ' . $oldPrice . ' به ' . $data['rough_price'] . " تغییر کرد.\n";
        }
        if ($order->requested_price != $request->get('requested_price') && $request->get('requested_price')) {
            $oldPrice = $order->requested_price ?? 'بدون قیمت';
            $note .= 'مبلغ قابل پرداخت از ' . $oldPrice . ' به ' . $data['requested_price'] . " تغییر کرد.\n";
        }
        if ($order->final_price != $request->get('final_price') && $request->get('final_price')) {
            $oldPrice = $order->final_price ?? 'بدون قیمت';
            $note .= 'قیمت حدودی از ' . $oldPrice . ' به ' . $data['final_price'] . " تغییر کرد.\n";
        }
        if ($order->admin_note != $request->get('admin_note') && $request->get('admin_note')) {
            $note .= 'توضیحات قبلی کارشناس:  ' . $order->admin_note  . ".\n";
        }
        if ($order->status != $request->get('status') && $request->get('status')) {
            $note .= 'وضعیت سفارش از ' . $order->status . ' به ' . $data['status'] . " تغییر کرد.\n";
        }

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
        if ($order->save()) {
            // if ($note) {
            //     $order->addNote($note);
            // }
            if (!empty($note))
                $order->metas()->create(['name' => 'note', 'value' => $note, 'order_id' => $order->id, 'user_id' => auth('sanctum')->user()->id]);
            return app('res')->success(new OrderResource($order), 'Order updated successfully.');
        }
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
        $notes = OrderMeta::where('order_id', $order->id)->where('name', 'note')->orderBy('id', 'DESC')->with('user:id,name,tel')->get();
        return app('res')->success(
            $notes
        );
    }
}
