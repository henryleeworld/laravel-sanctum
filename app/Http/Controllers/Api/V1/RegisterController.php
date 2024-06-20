<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Traits\HttpResponsesTrait;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group Auth endpoints
 */
class RegisterController extends Controller
{
    use HttpResponsesTrait;

    public function register(StoreUserRequest $request) 
    {
        $request->validated($request->only(['name', 'email', 'password']));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }
}
