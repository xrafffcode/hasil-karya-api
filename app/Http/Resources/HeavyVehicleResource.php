<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HeavyVehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'brand' => $this->brand,
            'model' => $this->model,
            'production_year' => $this->production_year,
            'vendor' => new VendorResource($this->vendor),
            'is_active' => $this->is_active,
        ];
    }
}
