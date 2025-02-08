<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SerializerManufacturerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $uniqueId = Rule::unique('App\Models\SerializerManufacturer', 'id');
        $uniqueName = Rule::unique('App\Models\SerializerManufacturer', 'name');

        if ($this->serializer_manufacturer) {
            $uniqueId->ignore($this->serializer_manufacturer);
            $uniqueName->ignore($this->serializer_manufacturer);
        }

        return [
            'id' => [
                'required',
                'size:3',
                'alpha:ascii',
                $uniqueId,
            ],
            'name' => [
                'required',
                'max:255',
                $uniqueName,
            ],
        ];
    }
}
