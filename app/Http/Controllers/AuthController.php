<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\IrMobile;
use App\Services\Helpers\Helper;
use App\Services\Sms\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Get user phone number in 'tel' from request.
     * on success return a hash code that must be sent with user's tel and OTP.
     */
    public function login(Request $request, Helper $helper, Sms $sms)
    {
        $data = $request->all();
        $data['tel'] = $helper->prepareTel($helper->faToEnNum($request->get('tel')));

        $validator = Validator::make($data, [
            'tel' => ['required', new IrMobile],
        ]);

        if ($validator->fails()) {
            return app('res')->error('validation error', $validator->errors());
        }
        $user = User::where('tel', $data['tel'])->first();
        //new user
        if (empty($user)) {
            $user = new User;
            $user->tel = $data['tel'];
            $user->save();
        } else {
            if ($user->status == 0)
                return app('res')->error('user disabled', ['error' => ['حساب کاربری شما غیر فعال شده است.']]);
        }

        $token = rand(10000, 99999);
        if (!$sms->sendOtp($data['tel'], $token)) {
            return app('res')->error('ratelimit', ['error' => ['لطفا چند دقیقه دیگر امتحان کنید.']]);
        }
        $hash = Str::random(18);
        $user->hash = hash('md5', $hash);
        $user->otp = bcrypt($token);
        $user->otp_expire = time() + config('constants.sms.otpLifeTime');
        $user->save();
        return app('res')->success(['hash' =>   $hash]);
    }

    /**
     * check 'tel', 'otp', 'hash' from request.
     */
    public function checkLoginCode(Request $request, Helper $helper)
    {
        $data = $request->all();
        $data['tel'] = $helper->prepareTel($helper->faToEnNum($request->get('tel')));

        $validator = Validator::make($data, [
            'otp' => ['required', 'numeric'],
            'hash' => ['required', 'string'],
            'tel' => ['required', new IrMobile],
            'remember' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return app('res')->error('validation error', $validator->errors());
        }

        $user = User::where('tel', $data['tel'])->firstOrFail();

        if ($user->hash !=  hash('md5', $data['hash'])) {
            return app('res')->error('wrong hash', ['error' => ['کد اعتبارسنجی/هش اشتباه است.']]);
        }

        if ($user->otp_expire < time()) {
            return app('res')->error('exipred', ['error' =>[ 'کد تایید منقضی شده است.']]);
        }
        if (Hash::check($request->get('otp'), $user->otp)) {
            auth()->login($user,true);
            $user->otp_expire = null;
            $user->otp = null;
            $user->save();
            return app('res')->success(['apiToken' => $user->createToken('apiToken1')->plainTextToken, 'role' => $user->role]);
        } else {
            return app('res')->error('wrong code', ['error' => ['کد تایید اشتباه است.']]);
        }
    }
}
