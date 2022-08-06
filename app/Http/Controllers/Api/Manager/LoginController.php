<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Manager\LoginRequest;
use App\Http\Resources\Manager\AuthManagerRTO;
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
                'fcm_token' => $request['fcm_token'],
                'os' => $request['os'],
                'last_session_id' => session()->getId(),
            ]);
            return response()->json(new AuthManagerRTO($user), 200);
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
