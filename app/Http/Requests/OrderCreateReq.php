<?php

namespace App\Http\Requests;

use App\Rules\FaAlpha;
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
            //samsung,apple,xiaomi,huawei,lg,htc,oppo,vivo,realme,oneplus,nokia,sony,blackberry,motorola,lenovo,xiaolajiao
            'device_type' => ['required', 'in:mobile,tablet,laptop'],
            'device_brand' => ['required'],
            'device_model' => ['required', 'string','max:32','min:2'],
            'user_note' =>  ['required', 'string','max:512','min:3'],
            'name' => ['required', 'string','max:64','min:3', new FaAlpha],
            'national_id' => ['required', 'string','max:64','min:3'],
            'province_id' => ['required', 'exists:provinces,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'address' => ['required', 'string','max:128','min:3'],
            'lat' => ['nullable', 'numeric'],
            'lon' => ['nullable', 'numeric'],
        ];
    }
}
