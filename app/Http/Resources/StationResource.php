<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StationResource extends JsonResource
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
            'province' => $this->province,
            'regency' => $this->regency,
            'district' => $this->district,
            'subdistrict' => $this->subdistrict,
            'category' => $this->category,
            'material' => new MaterialResource($this->material),
            'is_active' => $this->is_active,
        ];
    }
}
