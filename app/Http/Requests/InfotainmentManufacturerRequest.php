<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InfotainmentManufacturerRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $uniqueName = Rule::unique('App\Models\InfotainmentManufacturer', 'name');

        if ($this->infotainment_manufacturer) {
            $uniqueName->ignore($this->infotainment_manufacturer);
        }

        return [
            'name' => [
                'required',
                'max:255',
                $uniqueName,
            ],
        ];
    }
}
