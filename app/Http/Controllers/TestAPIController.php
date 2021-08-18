<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestAPIController extends Controller
{
   // indexアクションを定義（indexメソッドの定義と同義)
   public function index()
   {
      $value = ['var' => true];
		return response()->json(
         $value, 
         200, 
         ['Content-Type' => 'application/json'],
         JSON_UNESCAPED_SLASHES
      );
   }
}