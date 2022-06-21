<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>نتیجه‌ی پرداخت</title>
</head>
<style>
   p,h3,h4{
      text-align: center;
      direction: rtl;
   }
</style>
<body>
   <h4>
         پرداخت با موفقیت انجام شد.
   </h4>
   <p>
      شماره ارجاع بانک: {{ $payment->bank_sale_refrence_id }}
   </p>
   <p>
      شماره سفارش: {{ $payment->bank_sale_order_id }}
   </p>
   <p>
      <b>
         <a href='{{ url("https://etebarkala.com/services/dashboard/singleOrder?orderId={$payment->order->id}") }}'>
            بازگشت به اعتبارسرویس
         </a>
      </b>
   </p>
</body>

</html>