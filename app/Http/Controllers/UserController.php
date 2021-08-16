<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class UserController extends Controller
{
   // indexアクションを定義（indexメソッドの定義と同義)
   public function getStudents()
   {    
        $genre = new Genre();
        $type = $genre -> find(1);
        $value = [
            'var' => true,
            'type' => $type
        ];
        return response()->json(
            $value, 
            200, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
   }
}