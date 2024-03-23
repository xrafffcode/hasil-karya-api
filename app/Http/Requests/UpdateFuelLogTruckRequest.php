<?php

namespace App\Http\Requests;

use App\Enum\FuelTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFuelLogTruckRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|unique:fuel_logs,code,'.$this->route('id').',id',
            'date' => 'required|date',
            'truck_id' => 'required|exists:trucks,id',
            'driver_id' => 'required|exists:drivers,id',
            'station_id' => 'required|exists:stations,id',
            'gas_operator_id' => 'required|exists:gas_operators,id',
            'fuel_type' => 'required|string',
            'volume' => 'required|numeric|min:0',
            'odometer' => 'required|numeric|min:0',
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

        if (! $this->has('fuel_type')) {
            $this->merge(['fuel_type' => FuelTypeEnum::DIESEL->value]);
        }

        if (! $this->has('remarks')) {
            $this->merge(['remarks' => '']);
        }
    }
}
