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
                return app('res')->error('حساب شما غیر فعال است.');
        }

        $token = rand(10000, 99999);
        if (!$sms->sendOtp($data['tel'], $token)) {
            return redirect(route('login'))->withErrors(['tel' => 'مشکلی در ارسال پیامک پیش آمده، لطفا چند دقیقه‌ی دیگر مجددا امتحان کنید.']);
        }
        $hash = hash('md5', Str::random(12));
        $user->hash = $hash;
        $user->otp = bcrypt($token);
        $user->otp_expire = time() + config('constants.sms.otpLifeTime');
        $user->save();
        return app('res')->success(['hash' => $hash]);
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

        if ($user->hash != $data['hash']) {
            return app('res')->error('کد اعتبارسنجی/هش اشتباه است.');
        }

        if ($user->otp_expire < time()) {
            return app('res')->error('کد تایید منقضی شده است.');
        }
        if (Hash::check($request->get('otp'), $user->otp)) {
            auth()->login($user, ($request->get('remember')));
            $user->otp_expire = null;
            $user->save();
            return app('res')->success(['apiToken' => $user->createToken('apiToken1')->plainTextToken]);
        } else {
            return app('res')->error('کد تایید اشتباه است.');
        }
    }
}
