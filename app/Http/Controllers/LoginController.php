<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\User;

class LoginController extends Controller
{
   // indexアクションを定義（indexメソッドの定義と同義)
   public function Login(Request $request)
   {
        $value = $request->input('value');
        return view('home')->with('val', $value);
        
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