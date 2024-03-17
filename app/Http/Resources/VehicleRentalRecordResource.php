<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleRentalRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $startDate = new \DateTime($this->start_date);
        $endDate = clone $startDate;
        $endDate->modify('+'.$this->rental_duration.' days');

        return [
            'id' => $this->id,
            'code' => $this->code,
            'truck' => new TruckResource($this->truck),
            'heavy_vehicle' => new HeavyVehicleResource($this->heavyVehicle),
            'start_date' => $startDate->format('Y-m-d H:i:s'),
            'rental_duration' => $this->rental_duration,
            'end_date' => $endDate->format('Y-m-d H:i:s'),
            'rental_cost' => $this->rental_cost,
            'is_paid' => $this->is_paid,
            'remarks' => $this->remarks,
            'payment_proof_image' => $this->payment_proof_image,
            'payment_proof_image_url' => $this->payment_proof_image ? asset('storage/'.$this->payment_proof_image) : '',
        ];
    }
}
