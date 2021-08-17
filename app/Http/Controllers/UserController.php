<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\User;

class UserController extends Controller
{
   // indexアクションを定義（indexメソッドの定義と同義)
   public function getStudents()
   {    
        $users = new User();
        // $type = $user -> find(1);
        $user = $users -> select('name', 'email')->get();
        $value = [
            'response' => $user
        ];
        return response()->json(
            $value, 
            200, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
   }
}