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
        return [
            'id' => $this->id,
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
            'created_at' => $this->created_at,
        ];
    }
}
