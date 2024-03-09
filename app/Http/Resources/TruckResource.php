<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TruckResource extends JsonResource
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
            'capacity' => $this->capacity,
            'production_year' => $this->production_year,
            'vendor' => new VendorResource($this->vendor),
            'is_active' => $this->is_active,
        ];
    }
}
