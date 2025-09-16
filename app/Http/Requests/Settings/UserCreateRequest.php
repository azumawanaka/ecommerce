<?php

namespace App\Http\Requests\Settings;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Password::defaults()],
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
        ];
    }
}
