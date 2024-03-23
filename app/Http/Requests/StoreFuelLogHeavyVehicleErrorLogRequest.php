<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFuelLogHeavyVehicleErrorLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'nullable',
            'date' => 'nullable',
            'heavy_vehicle_id' => 'nullable',
            'driver_id' => 'nullable',
            'station_id' => 'nullable',
            'gas_operator_id' => 'nullable',
            'fuel_type' => 'nullable',
            'volume' => 'nullable',
            'odometer' => 'nullable',
            'remarks' => 'nullable',
            'error_log' => 'nullable',
        ];
    }

    public function prepareForValidation()
    {
        if (! $this->has('code')) {
            $this->merge([
                'code' => null,
            ]);
        }

        if (! $this->has('date')) {
            $this->merge([
                'date' => null,
            ]);
        }

        if (! $this->has('heavy_vehicle_id')) {
            $this->merge([
                'heavy_vehicle_id' => null,
            ]);
        }

        if (! $this->has('driver_id')) {
            $this->merge([
                'driver_id' => null,
            ]);
        }

        if (! $this->has('station_id')) {
            $this->merge([
                'station_id' => null,
            ]);
        }

        if (! $this->has('gas_operator_id')) {
            $this->merge([
                'gas_operator_id' => null,
            ]);
        }

        if (! $this->has('fuel_type')) {
            $this->merge([
                'fuel_type' => null,
            ]);
        }

        if (! $this->has('volume')) {
            $this->merge([
                'volume' => null,
            ]);
        }

        if (! $this->has('odometer')) {
            $this->merge([
                'odometer' => null,
            ]);
        }

        if (! $this->has('remarks')) {
            $this->merge([
                'remarks' => null,
            ]);
        }

        if (! $this->has('error_log')) {
            $this->merge([
                'error_log' => null,
            ]);
        }
    }
}
