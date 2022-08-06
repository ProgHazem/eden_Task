<?php

namespace App\Http\Requests\Api\Regular;

use App\Http\Requests\Api\ApiMasterRequest;

class JobRequest extends ApiMasterRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
        ];
    }
}
