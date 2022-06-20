<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Order;
use App\Models\Payment as ModelPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
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
        $perPage = request()->get('perPage', 25);
        $payments = ModelPayment::orderby('id', 'desc')->paginate($perPage);
        return app('res')->success(PaymentResource::collection($payments));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pay(Order $order)
    {
        $this->checkPendingOrders();

        if (!$order->requested_price)
            return app('res')->error('order requested price not set');

        $payment = new ModelPayment();
        $payment->amount = $order->requested_price;
        $payment->user_id = auth('sanctum')->user()->id;
        $payment->order_id = $order->id;
        $payment->save();

        return Payment::callbackUrl(url("api/pay/verify/{$payment->id}"))->purchase(
            (new Invoice)->amount($order->requested_price),
            function ($driver, $transactionId) use ($order, $payment) {
                $payment->ref_id = $transactionId;
                $payment->save();
            }
        )->pay()->toJson();
    }

    public function verify(Request $request, ModelPayment $payment)
    {
        try {
            $cardInfo = '';
            $receipt = Payment::amount($payment->amount)->transactionId($payment->ref_id)->verify();
            $payment->status = config('constants.payment.status.paid');
            $payment->bank_sale_refrence_id = $receipt->getReferenceId();
            if ($request->get('SaleOrderId'))
                $payment->bank_sale_order_id = $request->get('SaleOrderId');
            if ($request->get('CardHolderPan'))
                $payment->card_info = $cardInfo .= $request->get('CardHolderPan');

            $payment->save();
            $order = Order::find($payment->order_id);
            $order->paid_price += $payment->amount;
            $order->requested_price = 0;
            $order->save();

            return view('payment.verify-success', compact('payment'));
        } catch (InvalidPaymentException $exception) {
            /**
             * when payment is not verified, it will throw an exception.
             * We can catch the exception to handle invalid payments.
             * getMessage method, returns a suitable message that can be used in user interface.
             **/
            return view('payment.verify-error', compact('payment', 'exception'));
        }
    }

    /**
     * check pending orders before creat enew one
     */
    private function checkPendingOrders()
    {
        $createdPayment = ModelPayment::where('user_id', auth('sanctum')->user()->id)->where('status', config('constants.payment.status.pending'))->first();
        if ($createdPayment) {
            $createdPayment->status = config('constants.payment.status.canceled');
            $createdPayment->save();
        }
    }
}
