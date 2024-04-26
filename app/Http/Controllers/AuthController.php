<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function getToken()
    {
        $username = request()->header('x-username');
        $password = request()->header('x-password');
        $credentials = [
            'email' => $username,
            'password' => $password
        ];

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json([
                "metadata" => array (
                    "message" => "Username atau Password Tidak Sesuai",
                    "code" => 201
                )
            ]);
        }

        return response()->json([
            "response" => array(
                "token" =>  $token
            ),
            "metadata" => array (
                "message" => "Ok",
                "code" => 200
            )
        ]);
    }
}
