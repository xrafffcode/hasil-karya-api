<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:checkers,code',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:checkers,email',
            'is_active' => 'required|boolean',
        ];
    }
}
