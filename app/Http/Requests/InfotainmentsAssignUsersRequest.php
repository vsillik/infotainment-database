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
                'array',
                'min:1',
            ],
            'infotainments.*' => [
                'exists:\App\Models\Infotainment,id',
            ],
            'users' => [
                'array',
                'min:1',
            ],
            'users.*' => [
                'exists:\App\Models\User,id',
            ],
        ];
    }
}
