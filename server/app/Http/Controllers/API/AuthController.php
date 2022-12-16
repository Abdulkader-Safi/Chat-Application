<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller
{
    /**
     * Create new User
     * @param  Illuminate\Http\Request $req
     * @return Illuminate\Http\JsonResponse
     */
    public function register(Request $req): JsonResponse
    {

        $validator = Validator::make(
            $req->all(),
            [
                'name' => ['required', 'string', 'min:2', 'max:191', 'unique:users'],
                'email' => ['required', 'string', 'unique:users', 'email'],
                'password' => ['required', 'string', 'confirmed', 'min:8'],
                'password_verify' => ['required', 'string', 'confirmed', 'min:8']
            ]
        );

        if ($req->password === $req->password_verify) {
            $user = User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
            ]);
        } else {
            return response()->json([
                "status" => 401,
                "massage" => "Password and Password Verification does not match"
            ]);
        }

        $token = $user->createToken('MyAppToken')->plainTextToken;

        return response()->json([
            "status" => 200,
            "massage" => "User Created Successfully",
            "token" => $token,
            "data" => $user
        ]);
    }
}
