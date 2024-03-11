<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FuelLogResource extends JsonResource
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
            'date' => $this->date,
            'formatted_date' => $this->formatted_date,
            'truck' => TruckResource::make($this->whenLoaded('truck')),
            'heavy_vehicle' => HeavyVehicleResource::make($this->whenLoaded('heavy_vehicle')),
            'driver' => DriverResource::make($this->whenLoaded('driver')),
            'station' => StationResource::make($this->whenLoaded('station')),
            'gas_operator' => GasOperatorResource::make($this->whenLoaded('gas_operator')),
            'fuel_type' => $this->fuel_type,
            'volume' => $this->volume,
            'odometer' => $this->odometer,
            'hourmeter' => $this->hourmeter,
            'remarks' => $this->remarks,
        ];
    }
}
