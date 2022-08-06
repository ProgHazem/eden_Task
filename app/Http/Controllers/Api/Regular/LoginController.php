<?php

namespace App\Http\Controllers\Api\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Regular\LoginRequest;
use App\Http\Resources\Regular\AuthRegularRTO;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $user = User::where(['email' => $request['email']])->first();
        if (auth()->attempt($credentials)) {
            auth()->loginUsingId($user->id);
            $user->update([
                'fcm' => $request['fcm'],
                'device-type' => $request['device-type'],
            ]);
            return response()->json(new AuthRegularRTO($user), 200);
        }
        return response()->json(['message' => "Wrong credentials"], 401); // HTTP_UNAUTHORIZED
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()->token()->revoke()) {
            $request->user()->update([
                'device_token' => '',
            ]);
            return response()->json(['message' => "Logged out"], JsonResponse::HTTP_OK); // 200
        }
        return response()->json(null, JsonResponse::HTTP_UNAUTHORIZED); // 401
    }
}
