<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var bool
     */
    public $loginAfterSignUp = true;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'E-mail ou senha inválidos',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
}
