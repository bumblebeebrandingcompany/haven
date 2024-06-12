<?php

namespace App\Http\Controllers\Api\V1\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(["code" => 200, 'message'=>'Login successfully', 'token' => $token]);
    }

    public function logout(Request $request) {
        auth('web')->logout();

        $request->session()->flush();

        return response()->json(['message' => "Logout done successfully"]);
    }
}
