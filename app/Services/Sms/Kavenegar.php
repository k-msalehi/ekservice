<?php

namespace App\Services\Sms;

use App\Models\Sms;
use App\Services\Sms\Sms as SmsInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Kavenegar implements SmsInterface
{
      private $apiKey = '5A50384832526A49393172734A766B49744B4849594E382B417A6B704B4554636B4F3942346B6E6C6975303D';
      private $apiUrl = 'https://api.kavenegar.com/v1/';
      private $sms;

      public function __construct()
      {
            $this->sms = new Sms();
      }

      public function setApiKey($apiKey)
      {
            $this->apiKey = $apiKey;
      }

      public function sendOtp($to, $code): bool
      {
            $this->sms->type = 'otp';
            $this->sms->created_at = time();

            $res = Http::timeout(6)->get("https://api.kavenegar.com/v1/{$this->apiKey}/verify/lookup.json", [
                  'receptor' =>  $to,
                  'token' => $code,
                  'template' => 'servicekala-auth',
            ]);
            if ($res->successful()) {
                  return true;
            } else {
                  $body = $res->body();
                  Log::channel('sms')->warning("SMS not send. provider:Kavenegar, tel:{$to}, code:{$code}, timestamp: " . time() . ", response: {$body}");
                  return false;
            }
            return false;
      }
}
