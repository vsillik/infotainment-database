<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InfotainmentManufacturerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
