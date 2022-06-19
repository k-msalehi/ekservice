<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $order =  [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'device_brand' => $this->device_brand,
            'device_type' => $this->device_type,
            'device_model' => $this->device_model,
            'name' => $this->name,
            'email' => $this->email,
            'city_id' => $this->city_id,
            'address' => $this->address,
            'national_id' => $this->national_id,
            'lon' => $this->lon,
            'lat' => $this->lat,
            'user_note' => $this->user_note,
            'admin_note' => $this->admin_note,
            'rough_price' => $this->rough_price,
            'requested_price' => $this->requested_price,
            'paid_price' => $this->paid_price,
            'final_price' => $this->final_price,
            'status' => $this->status,
            'status_text' => $this->status_text,
            'created_at' => $this->created_at,
        ];

        if (auth('sanctum')->user()->role == config('constants.roles.admin') || auth('sanctum')->user()->role == config('constants.roles.expert'))
            $order['payments'] = $this->payments;
        elseif (auth('sanctum')->user()->role == config('constants.roles.customer'))
            $order['payments'] = $this->payments()->get([
                'id', 'amount', 'ref_id', 'bank_sale_order_id', 'bank_sale_refrence_id', 'status', 'created_at', 'updated_at'
            ]);

        // if (auth('sanctum')->user()->role == config('constants.roles.admin') || auth('sanctum')->user()->role == config('constants.roles.expert'))
        //     $order['notes'] = $this->notes();
        return $order;
    }
}
