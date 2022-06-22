<?php

namespace App\Http\Requests;

use App\Rules\IrMobile;
use App\Services\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateReq extends FormRequest
{
    protected function prepareForValidation()
    {
        $helper = new Helper;
        $tel = $helper->faToEnNum($this->tel);
        $this->merge(['tel' => $tel]);
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'max:64', 'min:3'],
            'email' => ['nullable', 'string', 'email', 'unique:users'],
            // 'tel' => ['required', Rule::unique('users')->ignore($this->user->id), new IrMobile],
            'role' => ['required', 'string', Rule::in(config('constants.roles'))],
        ];
    }
}
