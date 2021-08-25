<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest; 
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\RegisterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    private $registerService;

    public function __construct(RegisterService $registerservice)
    {
        $this->registerService = $registerservice;
    }

    public function register(RegisterRequest $request)
    {

        // 一般ユーザは確認できない
        try {
            $request->user()->must_be_Admin();
        }catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }

        // ユーザを登録する
        try {
            $this->registerService->register($request);
            return response()->json('User registration completed', Response::HTTP_OK);
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }
    }
}