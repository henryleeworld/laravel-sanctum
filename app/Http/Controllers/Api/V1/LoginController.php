<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginUserRequest;
use App\Http\Traits\HttpResponsesTrait;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * @group Auth endpoints
 */
class LoginController extends Controller
{
    use HttpResponsesTrait;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->only(['email', 'password']));

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', __('Credentials do not match'), 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    public function logout() 
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => __('You have succesfully been logged out and your token has been removed')
        ]);
    }
}
