<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialMovementErrorLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'nullable|string',
            'driver_id' => 'nullable|string',
            'truck_id' => 'nullable|string',
            'station_id' => 'nullable|string',
            'checker_id' => 'nullable|string',
            'date' => 'nullable|string',
            'truck_capacity' => 'nullable|string',
            'observation_ratio_percentage' => 'nullable|string',
            'solid_ratio' => 'nullable|string',
            'remarks' => 'nullable|string',
            'error_log' => 'required|string',
        ];
    }
}
