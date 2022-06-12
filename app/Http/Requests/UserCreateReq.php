<?php

namespace App\Http\Requests;

use App\Rules\IrMobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCreateReq extends FormRequest
{
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
            'tel' => ['required','unique:users,tel' ,new IrMobile],
            'role' => ['required', 'string', Rule::in(config('constants.roles'))],
        ];
    }
}
