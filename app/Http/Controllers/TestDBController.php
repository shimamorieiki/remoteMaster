<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestDBController extends Controller
{
    // indexアクションを定義（indexメソッドの定義と同義)
    public function index()
    {
        $items = \DB::table('grades')->get();
        return response()->json(
            $items, 
            200, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
            );
   }
}