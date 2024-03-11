<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFuelLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|unique:fuel_logs,code',
            'date' => 'required|date',
            'truck_id' => 'required_without:heavy_vehicle_id|exists:trucks,id',
            'heavy_vehicle_id' => 'required_without:truck_id|exists:heavy_vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'station_id' => 'required|exists:stations,id',
            'gas_operator_id' => 'required|exists:gas_operators,id',
            'fuel_type' => 'required|string',
            'volume' => 'required|numeric|min:0',
            'odometer' => 'required_if:truck_id,!=,null|numeric|min:0',
            'hourmeter' => 'required_if:heavy_vehicle_id,!=,null|numeric|min:0',
            'remarks' => 'nullable|string',
        ];
    }

    public function prepareForValidation()
    {
        if (! $this->has('code')) {
            $this->merge(['code' => 'AUTO']);
        }

        if (! $this->has('date')) {
            $this->merge(['date' => now()]);
        }

        if (! $this->has('remarks')) {
            $this->merge(['remarks' => '']);
        }
    }
}
