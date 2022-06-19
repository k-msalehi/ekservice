<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentUpdateReq;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 25);
        $data = request()->all();

        return  app('res')->success(
            new PaymentCollection(Payment::filter($data)->orderBy('id', 'DESC')->paginate($perPage)),
            'Payments fetched successfully.'
        );
    }

    public function show(Payment $payment)
    {
        return app('res')->success(new PaymentResource($payment));
    }

    public function update(PaymentUpdateReq $request, Payment $payment)
    {
        $data = $request->validated();
        $payment->status = $data['status'] ?? $payment->status;
        $payment->note = $data['note'] ?? $payment->note;
        if ($payment->isDirty())
            $payment->save();
        return app('res')->success(new PaymentResource($payment), 'Payment updated successfully.');
    }
}
