<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\Api\LoginUserRequest;
use App\Permissions\V1\Abilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    /**
     * Log a user into the application.
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => [__('The provided credentials are incorrect.')],
                'password' => [__('The provided credentials are incorrect.')],
            ]);
        }

        $user = auth()->user();
        $token = $user->createToken('authToken', Abilities::getAbilities($user), now()->addHours(8))->plainTextToken;

        return $this->responseSuccess(__('Authenticated'), ['token' => $token]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->responseSuccess(__('Logged out'));
    }
}
