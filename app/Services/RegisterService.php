<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use \Symfony\Component\HttpFoundation\Response;

class RegisterService
{
    public function register(Request $request)
    {
        try {
            User::create([
                'name' =>  $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id
            ]);
        } catch (\Throwable $th) {
            throw new HttpResponseException(response("Server Error.", Response::HTTP_INTERNAL_SERVER_ERROR));
        }
    }

}