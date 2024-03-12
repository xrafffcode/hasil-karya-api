<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRentalRecordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:vehicle_rental_records,code,'.$this->route('id').',id',
            'truck_id' => 'required_without:heavy_vehicle_id|exists:trucks,id',
            'heavy_vehicle_id' => 'required_without:truck_id|exists:heavy_vehicles,id',
            'start_date' => 'required|date',
            'rental_duration' => 'required|numeric|min:1',
            'rental_cost' => 'required|numeric|min:0',
            'is_paid' => 'required|boolean',
            'remarks' => 'nullable|string|max:255',
        ];
    }

    public function prepareForValidation()
    {
        if (! $this->has('remarks')) {
            $this->merge(['remarks' => '']);
        }
    }
}
