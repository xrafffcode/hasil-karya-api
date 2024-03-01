<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:stations,code,'.$this->route('station'),
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ];
    }
}
