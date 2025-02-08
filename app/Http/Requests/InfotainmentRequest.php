<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfotainmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'infotainment_manufacturer_id' => [
                'bail',
                'required',
                'integer',
                'exists:\App\Models\InfotainmentManufacturer,id',
            ],
            'serializer_manufacturer_id' => [
                'bail',
                'required',
                'size:3',
                'exists:\App\Models\SerializerManufacturer,id',
            ],
            'product_id' => [
                'required',
                'regex:/^[a-f0-9]{1,4}$/i',
            ],
            'model_year' => [
                'required',
                'integer',
                'min:1990',
                'max:2245',
            ],
            'part_number' => [
                'required',
                // XXX.XXX.XXX[.X]
                'regex:/^[a-z0-9]{3}\.[a-z0-9]{3}\.[a-z0-9]{3}(\.[a-z0-9])?$/i',
            ],
            'compatible_platforms' => [
                'max:1500',
            ],
            'internal_code' => [
                'max:150',
            ],
            'internal_notes' => [
                'max:1500',
            ],
        ];
    }
}
