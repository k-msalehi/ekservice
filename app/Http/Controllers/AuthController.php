<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\IrMobile;
use App\Services\Helpers\Helper;
use App\Services\Sms\Sms;
use Illuminate\Http\Request;
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
        $data['tel'] = $helper->prepareTel($helper->faToEnNum($data['tel']));

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

        return app('res')->success(['hash' => $hash]);
        // return app('res')->success($user->createToken('mainToken', ['wallpaper:manage'])->plainTextToken);
    }

    /**
     * check 'otp'
     */
    public function checkLoginCode(Request $request, Helper $helper, $tel)
    {
        $data = $request->all();
        $data['tel'] = $helper->prepareTel($helper->faToEnNum($data['tel']));

        $validator = Validator::make($data, [
            'otp' => ['required', 'numeric'],
            'hash' => ['required', 'string'],
            'tel' => ['required', new IrMobile],
        ]);

        if ($validator->fails()) {
            return app('res')->error('validation error', $validator->errors());
        }

        $user = User::where('tel', $data['tel'])->firstOrFail();
        $otp = $user->otp;
        if ($otp->datetime < (time() - 3 * 60)) {
            return $this->expiredLoginRedirect();
        }
        if (Hash::check($request->get('otp'), $otp->code)) {
            $request->session()->regenerate();
            auth()->login($user, ($request->get('remember') == 'yes'));
            $this->updateCartData();
            return redirect()->intended('admin/dashboard');
        } else {
            return back()->withErrors(['otp' => 'کد تایید وارد شده اشتباه است.']);
        }
    }
}
