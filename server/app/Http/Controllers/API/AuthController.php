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
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                'message' => $validator->messages() // TODO: frontend can not read this message using sweetalert need to fix
            ]);
        }

        if ($req->password === $req->password_confirmation) {
            $user = User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
            ]);
        } else {
            return response()->json([
                "status" => 400,
                "message" => "Password and Password Confirmation does not match"
            ]);
        }

        $token = $user->createToken($user->email . '_Token', [''])->plainTextToken;

        return response()->json([
            "status" => 200,
            "message" => "User Created Successfully",
            "token" => $token,
            'username' => $user->name,
        ]);
    }

    /**
     * login to  User
     * @param  Illuminate\Http\Request $req
     * @return Illuminate\Http\JsonResponse
     */
    public function login(Request $req): JsonResponse
    {
        $validator = Validator::make(
            $req->all(),
            [
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string', 'min:8'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                'message' => $validator->messages()
            ]);
        }

        $user = User::where('email', $req->email)->first();

        if (!$user || !Hash::check($req->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid Credentials'
            ]);
        }
        $token = $user->createToken($user->email . '_Token', [''])->plainTextToken;


        return response()->json([
            'status' => 200,
            'message' => "Login In Successfully",
            'username' => $user->name,
            'token' => $token,
        ]);
    }

    /**
     * login to  User
     * @param  Illuminate\Http\Request $req
     * @return Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 200,
            'message' => "Logged Out Successfully"
        ]);
    }
}
