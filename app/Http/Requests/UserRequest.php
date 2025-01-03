<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $uniqueEmail = Rule::unique(User::class, 'email');
        $passwordRule = 'required';

        if ($this->user) {
            $uniqueEmail->ignore($this->user);
            $passwordRule = 'nullable';
        }

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                $uniqueEmail,
            ],
            'password' => [
                $passwordRule,
                Rules\Password::defaults(),
            ],
        ];
    }
}