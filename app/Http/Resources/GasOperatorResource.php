<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GasOperatorResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->user->email,
            'is_active' => $this->is_active,
        ];
    }
}
