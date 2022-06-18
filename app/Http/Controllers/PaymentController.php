<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment as ModelPayment;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pay(Order $order)
    {
        $createdPayment = ModelPayment::where('user_id', auth('sanctum')->user()->id)->where('status', config('constants.payment.status.pending'))->first();
        if ($createdPayment) {
            $createdPayment->status = config('constants.payment.status.canceled');
            $createdPayment->save();
        }

        $order->requested_price ??= 25000;
        return Payment::purchase(
            (new Invoice)->amount($order->requested_price),
            function ($driver, $transactionId) use ($order) {
                $payment = new ModelPayment();
                $payment->amount = $order->requested_price;
                $payment->user_id = auth('sanctum')->user()->id;
                $payment->order_id = $order->id;
                $payment->ref_id = $transactionId;
                $payment->save();
            }
        )->pay()->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
