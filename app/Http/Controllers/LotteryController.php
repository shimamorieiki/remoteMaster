<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\User;

class LotteryController extends Controller
{

   // 当選者情報を取得する
   public function get_winner()
   {    
        // 投票結果を取得する
        // $users = new User();
        // $user = $users -> select('name', 'email')->get();
        $STATUSCODE = 200;
        $value = [
            'name' => 'name',
            'score' => '1'
        ];
        return response()->json(
            $value, 
            $STATUSCODE, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
   }

    // くじに申し込む
    public function post_voting(Request $request)
    {    
    
        $request_json = json_decode($request->getContent(),true);
        
        // 各要素を取得
        $user_id = $request_json["user_id"];
        $voting_number = $request_json["voting_number"];
        
        $votes = new Vote();
        // ユーザに投票権が存在するか確認する

        // ユーザに投票権があれば投票する
        // $votes->create()->where('name','=',$access_token)->get();
        
        // ユーザが正しく投票できているかを確認する
        // $user_id = $user[0]->id;

        // 正しく投票できていれば200
        $STATUSCODE = 200;
        // 投票できていなければエラーコード
        $STATUSCODE = 400;

        // 返却する要素を取得
        $value = [
            'message' => 'ok/not'
        ];

        return response()->json(
            $value, 
            $STATUSCODE, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
    }
}