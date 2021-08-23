<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        // $role = (1,管理者),(2,一般ユーザ)
        // 一般ユーザはユーザ登録できない
        $general_role_id = 1;
        if ($request->user()->role_type == $general_role_id) {
            return response()->json('You are not allowed.', Response::HTTP_BAD_REQUEST);
        }

        /** @var Illuminate\Validation\Validator $validator */
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $is_registred = User::create([
            'name' =>  $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);
        if ($is_registred) {
            return response()->json('User registration completed', Response::HTTP_OK);
        } else {
            return response()->json('Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}