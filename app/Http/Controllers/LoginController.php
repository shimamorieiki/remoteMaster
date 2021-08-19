<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\User;

class LoginController extends Controller
{
   // ログインを作ったけどもしかしたらlaravelに搭載されている機能を使うので必要ないかもしれない
   public function login(Request $request)
   {
        $users = new User();
        $user = $users -> select('name', 'email','password')->get();
        $flag = TRUE;
        if ($flag) {
            $STATUSCODE = 200;
            $value = [
                'response' => $user
            ];
        } else {
            $STATUSCODE = 400;
            $value = [
                'response' => "not authorized"
            ];
        }
        return response()->json(
            $value, 
            $STATUSCODE, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
   }
}