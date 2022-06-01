<?php
namespace App\Services\Sms;

use App\Models\Sms as ModelsSms;

interface Sms
{  
      public function __construct();
      public function setApiKey($api);
      public function sendOtp($to, $code) : bool;   
}
