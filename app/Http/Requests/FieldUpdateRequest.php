<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'description' => 'required|string',
            'sporttype' => 'required|exists:sporttypes,id',
            'province' => 'required|exists:provinces,id',
            'district' => 'required|exists:districts,id',
            'ward' => 'required|exists:wards,id',
            'address' => 'required|string|max:255',
            'images' => 'array|max:5',
        ];
    }
}
