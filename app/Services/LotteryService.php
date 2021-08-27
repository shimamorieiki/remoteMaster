<?php

namespace App\Services;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class LotteryService
{
    public function get_voting_numbers()
    {
        try {
            // 投票されたすべての数字を取得する
            $voting_numbers = Vote::select('voting_number')
            ->get()
            ->pluck("voting_number")
            ->all();
            return $voting_numbers;

        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->serverError());
        }
    }

    public function get_winner_and_number()
    {
        // 勝者を取得する
        $voting_numbers = $this->get_voting_numbers();
        $number_length = array_count_values($voting_numbers);
        
        $min_number = PHP_INT_MAX;
        foreach ($number_length as $key => $value) {
            if ($value == 1 && $key < $min_number ) {
                $min_number = $key;                
            }
        }

        // 最小値のuser_idを取得
        // 該当者なし
        if ($min_number == PHP_INT_MAX) {
            $value = [
                'winner_name' => 'null',
                'winner_voting_number' => '-1'
            ];
            return $value;
        }
        
        // 該当者あり
        try {
            // 該当するuserの名前を返す
            $winner_name = DB::table('users')
            ->join('votes', 'users.id', '=', 'votes.user_id')
            ->select('users.name')
            ->where('votes.voting_number','=',$min_number)
            ->first()
            ->name;
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->serverError());
        }

        $value = [
            'winner_name' => $winner_name,
            'winner_voting_number' => $min_number
        ];
        return $value;
    }

    public function vote(Request $request)
    {
        // ユーザが投票できる最小のポジティブタスク達成数
        // (最低でもポジティブタスクを15個達成しないと投票できない)
        $min_voting_positive_count = 15;

        // ユーザが投票できる最大のネガティブタスク達成数
        // (1つでもnegativeがあると投票できない)
        $max_voting_negative_count = 0;
        
        // ユーザのidを取得
        $user_id = $request->user()->id;

        // ユーザに投票権が存在するか確認する
        
        try {
            // 1. ポジティブタスクを15個以上達成しているか
            $positive_counts = DB::table('completes')
            ->join('tasks', 'completes.task_id', '=', 'tasks.id')
            ->where('user_id','=',$user_id)
            ->where('tasks.is_positive_check','=',TRUE)
            ->count();

        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->serverError());
        }

        try {
            // 2. ネガティブチェックがついているか
            $negative_counts = DB::table('completes')
            ->join('tasks', 'completes.task_id', '=', 'tasks.id')
            ->where('user_id','=',$user_id)
            ->where('tasks.is_positive_check','=',FALSE)
            ->count();

        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->serverError());
        }

        try {
            // 3. すでに投票したかを判断
            $is_user_voted = Vote::select()->where('user_id','=',$user_id)->exists();
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->serverError());
        }
        
        if ($positive_counts < $min_voting_positive_count) {
            throw new HttpResponseException(
                response()->badRequest("You Don't Have Enough Achievements To Vote.")
            );
        }

        if ($negative_counts > $max_voting_negative_count) {
            throw new HttpResponseException(
                response()->badRequest("People With Negative Check Cannot Vote.")
            );
        }

        if ($is_user_voted) {
            throw new HttpResponseException(
                response()->badRequest("You Have Already Voted.")
            );
        }

        try {
            // 投票を送信する
            Vote::create(
                [
                    'user_id' => $user_id,
                    'voting_number' => $request->voting_number
                ]
            );
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->serverError());
        }
    }
}