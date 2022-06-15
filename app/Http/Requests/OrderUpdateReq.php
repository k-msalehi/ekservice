<?php

namespace App\Http\Requests;

use App\Rules\FaAlpha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderUpdateReq extends FormRequest
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
            //samsung,apple,xiaomi,huawei,lg,htc,oppo,vivo,realme,oneplus,nokia,sony,blackberry,motorola,lenovo,xiaolajiao
            'device_type' => ['nullable', 'in:mobile,tablet,laptop'],
            'device_brand' => ['nullable', 'string', 'max:32'],
            'device_model' => ['nullable', 'string', 'max:32', 'min:2'],
            'admin_note' =>  ['nullable', 'string', 'max:512', 'min:3'],
            'name' => ['nullable', 'string', 'max:64', 'min:3', new FaAlpha],
            'status' => ['nullable', Rule::in(config('constants.order.status'))],
            'address' => ['nullable', 'string', 'max:255', 'min:3'],
            'rough_price' => ['nullable', 'numeric','min:1000','max:100000000'],
            'requested_price' => ['nullable', 'numeric','min:1000','max:100000000'],
            'final_price' => ['nullable', 'numeric','min:1000','max:100000000'],
            'lat' => ['nullable', 'numeric'],
            'lon' => ['nullable', 'numeric'],
        ];
    }
}
