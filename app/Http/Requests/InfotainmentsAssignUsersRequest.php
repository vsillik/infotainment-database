<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfotainmentsAssignUsersRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'infotainments' => [
                'required',
                'array',
                'min:1',
            ],
            'infotainments.*' => [
                'bail',
                'integer',
                'exists:\App\Models\Infotainment,id',
            ],
            'users' => [
                'required',
                'array',
                'min:1',
            ],
            'users.*' => [
                'bail',
                'integer',
                'exists:\App\Models\User,id',
            ],
        ];
    }
}
