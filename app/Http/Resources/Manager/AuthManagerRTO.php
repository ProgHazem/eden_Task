<?php

namespace App\Http\Resources\Manager;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthManagerRTO extends JsonResource
{
    public function toArray($request)
    {
        $tokenResult = $this->createToken('manager');
        $tokenResult->token->expires_at = Carbon::now()->addWeeks(1);

        return [
            "user" => [
                'id' => (int)$this->id,
                'name' => $this->name,
                'email' => $this->email,
            ],

            "access_token" => [
                'token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ],
        ];
    }
}
