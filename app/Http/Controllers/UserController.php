<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\User;
use App\Models\Role;
use App\Models\Complete;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use \Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

   // 特にログイン情報を使用することなくログインを行う
   public function get_user_info(Request $request)
   {    
        // storage/logs/laravel.logに情報を保存
        // info($request->user());

        // ユーザ情報を取得
        $user = $request->user();

        // 達成したカラムを取得する
        $completes = Complete::select()
        ->where('user_id','=',$user->id)
        ->get()
        ->pluck("task_id")
        ->all();
        
        // 全てのタスクを取得する
        $tasks = DB::table('tasks')
        ->join('genres', 'genres.id', '=', 'tasks.genre_id')
        ->join('grades', 'grades.id', '=', 'tasks.grade_id')
        ->select('tasks.*', 'genres.type as genre_type','grades.type as grade_type')
        ->get()
        ->all();

        // タスクを達成したかの情報を追加する
        for ($i=0; $i < count($tasks); $i++) { 
            $tasks[$i]->is_completed = in_array($tasks[$i]->id, $completes);
        }

        return response()->json(
            ['response' => $tasks],
            Response::HTTP_OK, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
   }

    // completeしたタスクを送信する
   public function post_completed_task(Request $request)
   {    
       
        $user_id = $request->user()->id;
        $task_id = $request->task_id;

        // ユーザが投票したかどうかの情報を取得
        $is_voted = Vote::select()
        ->where('user_id','=',$user_id)
        ->exists();
        
        // 投票していたらチェックのオンオフができない
        if ($is_voted) {
            return response()->json('Request Denied', Response::HTTP_BAD_REQUEST);
        }

        // 命名規則がわかりにくい
        // タスクをチェックしようとしたか外そうとしたか
        $is_task_checked = $request->is_task_checked;
        
        // すでにそのタスクにチェックしたか
        $is_task_completed = Complete::select()
                                ->where('task_id','=',$task_id)
                                ->where('user_id','=',$user_id)
                                ->exists();

        if ($is_task_completed && $is_task_checked) {
            // すでにチェックされている && チェックを外そうとしている => チェックを外す(レコードを物理削除)
            $is_completes_deleted = Complete::where('task_id','=',$task_id)
                                                ->where('user_id','=',$user_id)
                                                ->delete();
            if ($is_completes_deleted) {
                return response()->json('Accepted', Response::HTTP_OK);
            } else {
                return response()->json('Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        } elseif (!$is_task_completed && !$is_task_checked) {
            // まだチェックされていない && チェックをつけようとしている => チェックする(レコードを追加)
            $is_completes_inserted = Complete::insertGetId(
                [
                    'user_id' => $user_id,
                    'task_id' => $task_id
                ]
            );
            if ($is_completes_inserted) {
                return response()->json('Accepted', Response::HTTP_OK);
            } else {
                return response()->json('Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            // completeしたのに追加しようとしている
            // completeしていないのに削除しようとしている
            return response()->json('Request Denied', Response::HTTP_BAD_REQUEST);
        }
   }
}