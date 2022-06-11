<?php

return [
   'order' => [
      'status' => [
         'submited' => 1,
         'deliverySent1' => 2,
         'pickedByDelivery1' => '3',
         'pickedByHead' => '4',
         'debugging' => '5',
         'waitingForCustomerConfirm' => '6',
         'fixing' => '7',
         'cannotFix' => '8',
         'fixed' => '9',
         'deliverySent2' => '10',
         'completed' => '11',
         'autocanceled' => '12',
         'cancelRequestByCustomer' => '13',
         'canceledByCustomer' => '14',
         'canceledByHead' => '15',
      ],
   ],
   'roles' => [
      'admin' => 1,
      'expert' => 2,
      'customer' => 3,
   ],
   'statuses' => [
      'active' => 1,
      'ban' => 2,
   ],

   'sms' => [
      'otpLifeTime' => 900, //in seconds
   ],
];
