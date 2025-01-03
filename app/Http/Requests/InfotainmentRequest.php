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
                'required',
                'exists:\App\Models\InfotainmentManufacturer,id',
            ],
            'serializer_manufacturer_id' => [
                'required',
                'size:3',
                'exists:\App\Models\SerializerManufacturer,id',
            ],
            'product_id' => [
                'required',
                'size:4',
            ],
            'model_year' => [
                'required',
                'integer',
            ],
            'part_number' => [
                'required',
                'max:13',
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
