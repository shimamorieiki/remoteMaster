<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest; 
use App\Models\User;
use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use \Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    private $loginService;

    public function __construct(LoginService $loginservice)
    {
        $this->loginService = $loginservice;
    }

    public function login(LoginRequest $request)
    {
        // // ログインする
        try {
            $token = $this->loginService->login($request);
            return response()->json($token, Response::HTTP_OK);
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }
    }
}