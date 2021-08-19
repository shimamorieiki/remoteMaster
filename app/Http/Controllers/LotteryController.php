<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\User;
use App\Models\Vote;
use App\Models\Complete;

class LotteryController extends Controller
{

   // 当選者情報を取得する
   public function get_winner()
   {    
        // 投票結果を取得する
        $votes = Vote::select('voting_number')->get();
        $voting_numbers = array();
        foreach ($votes as $key => $value) {
            array_push($voting_numbers,$value["voting_number"]);
        }
        // 最小値を決める
        // {配列の要素,要素数}の連想配列を取得
        $number_length = array_count_values($voting_numbers);
        
        $min_number = PHP_INT_MAX;
        foreach ($number_length as $key => $value) {
            if ($value == 1 && $key < $min_number ) {
                $min_number = $key;                
            }
        }

        // 最小値のuser_idを取得
        if ($min_number == PHP_INT_MAX) {
            // 該当者なし
            $STATUSCODE = 400;
            $value = [
                'winner_name' => 'null',
                'winner_voting_number' => '-1'
            ];
        } else {
            // 該当者あり
            // 該当するuserの名前を返す
            $winner_id = Vote::select('user_id')
                            ->where('voting_number','=',$min_number)
                            ->first()
                            ->user_id;

            $winner_name = User::select('name')
                            ->where('id','=',$winner_id)
                            ->first()
                            ->name;

            $STATUSCODE = 200;
            $value = [
                'winner_name' => $winner_name,
                'winner_voting_number' => $min_number
            ];
        }

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

        // ユーザに投票権が存在するか確認する
        // 1. ユーザが達成したタスクの個数を取得(15個)
        $completes_count = Complete::select()->where('user_id','=',$user_id)->count();

        // 2. すでに投票したかを判断
        $is_user_voted = Vote::select()->where('user_id','=',$user_id)->exists();

        // 条件を元に投票する
        if ($completes_count > 15 && ! $is_user_voted) {
            // 投票する
            $is_voting_inserted = Vote::insertGetId(
                [
                    'user_id' => $user_id,
                    'voting_number' => $voting_number
                ]
            );
            
            // 正しく投票できたかを判断。
            if ($is_voting_inserted) {
                $STATUSCODE = 200;
                $message = "accepted";
            } else {
                $STATUSCODE = 400;
                $message = "denied";
            }
        } else {
            $STATUSCODE = 400;
            $message = "denied";
        }

        // 返却する要素
        $value = [
            'message' => $message
        ];

        return response()->json(
            $value, 
            $STATUSCODE, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
    }
}