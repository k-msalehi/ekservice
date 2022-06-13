<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderMetaCreateReq extends FormRequest
{
    protected function prepareForValidation()
    {
        if (request()->is('api/admin/orders/*/note')) {
            $this->merge(['name' => 'note']);
        }
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
            'name' => ['required', 'string', 'max:255', 'min:3', 'in:note'],
            'value' => ['required', 'string', 'max:255', 'min:3'],
        ];
    }
}
