<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>نتیجه‌ی پرداخت</title>
</head>
<style>
   p{
      text-align: center;
      direction: rtl;
   }
</style>
<body>
   <p>
      <b>
         خطا در پرداخت
      </b>
      <br>
      {{$exception->getMessage()}}
      <br>
      در صورت کسر وجه توسط بانک از حساب شما، مبلغ تا ۷۲ ساعت به حساب شما برگشت داده خواهد شد.
   </p>
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