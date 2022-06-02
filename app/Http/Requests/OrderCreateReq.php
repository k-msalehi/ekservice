<?php

namespace App\Http\Requests;

use App\Rules\IrMobile;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class OrderCreateReq extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        // throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
        throw new HttpResponseException(app('res')->error('validation error', $validator->errors()));
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
            'name' => 'required|string',
            'last_name' => 'required|string|email|unique:users,email',
            'password' => 'required|confirmed'
        ];
    }
}
