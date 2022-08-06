<?php

namespace App\Http\Requests\Api\Manager;

use App\Http\Requests\Api\ApiMasterRequest;

class LoginRequest extends ApiMasterRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|max:90|exists:users',
            'password' => 'required|string|min:6|max:20',
            'fcm' => 'required|string',
            'device-type' => 'required|in:android,ios',
        ];
    }
}
