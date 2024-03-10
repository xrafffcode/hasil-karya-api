<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TruckRentalRecordResource extends JsonResource
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
            'truck' => new TruckResource($this->truck),
            'start_date' => $startDate,
            'rental_duration' => $this->rental_duration,
            'end_date' => $endDate,
            'rental_cost' => $this->rental_cost,
            'is_paid' => $this->is_paid,
            'remarks' => $this->remarks,
        ];
    }
}
