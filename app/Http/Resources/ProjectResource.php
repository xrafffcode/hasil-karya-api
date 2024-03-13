<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'person_in_charge' => $this->person_in_charge,
            'amount' => $this->amount,
            'client' => new ClientResource($this->client),
            'province' => $this->province,
            'regency' => $this->regency,
            'district' => $this->district,
            'subdistrict' => $this->subdistrict,
            'status' => $this->status,
            'drivers' => DriverResource::collection($this->drivers),
            'trucks' => TruckResource::collection($this->trucks),
            'heavy_vehicles' => HeavyVehicleResource::collection($this->heavyVehicles),
            'stations' => StationResource::collection($this->stations),
            'checkers' => CheckerResource::collection($this->checkers),
            'technical_admins' => TechnicalAdminResource::collection($this->technicalAdmins),
            'gas_operators' => GasOperatorResource::collection($this->gasOperators),
        ];
    }
}
