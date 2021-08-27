<?php

namespace App\Services;
use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Models\User;
use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpFoundation\Response;

class LoginService
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            try {
                $user = User::whereEmail($request->email)->first();
                $user->tokens()->delete();
                $token = $user->createToken("login:user{$user->id}")->plainTextToken;
                return $token;
            } catch (\Throwable $th) {
                throw new HttpResponseException(response()->serverError());
            }            
        }
        throw new HttpResponseException(
            response()->badRequest("User Not Found.")
        );
    }
}