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
        try {
            // ログインする
            $token = $this->loginService->login($request);
            $response = ["token"=>$token];
            return response()->success($response);
        } catch (HttpResponseException $he) {
            // ユーザが見つからない時
            // 受け取り手がメッセージの内容を推測できないのは嬉しくない
            return response()->badRequest($he->getResponse()->original);
        }
    }
}