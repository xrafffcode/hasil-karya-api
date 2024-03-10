<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTruckRentalRecordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:truck_rental_records,code',
            'truck_id' => 'required|exists:trucks,id',
            'start_date' => 'required|date',
            'rental_duration' => 'required|numeric|min:1',
            'rental_cost' => 'required|numeric|min:0',
            'is_paid' => 'required|boolean',
            'remarks' => 'nullable|string|max:255',
        ];
    }
}
