<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => trans('auth.failed')], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'user'  => $user,
                'token' => $user->createToken('token-name'),
            ]
        ], 201);
    }
}
