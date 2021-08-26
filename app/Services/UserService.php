<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Genre;
use App\Models\User;
use App\Models\Role;
use App\Models\Complete;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserService
{
    public function get_user_info(int $user_id)
    {
        // 達成したカラムを取得する
        $completes = Complete::select()
        ->where('user_id','=',$user_id)
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

        return $tasks;
    }

    public function canVote(int $user_id)
    {
        // ユーザが投票したかどうかの情報を取得
        $is_voted = Vote::select()
        ->where('user_id','=',$user_id)
        ->exists();

        // 投票していたらチェックのオンオフができない
        if ($is_voted) {
            throw new HttpResponseException(response("You Can't Check After Vote.",  Response::HTTP_BAD_REQUEST));
        }
        
    }

    public function post_completed_task(Request $request)
    {

        $user_id = $request->user()->id;
        $task_id = $request->task_id;

        // 命名規則がわかりにくい
        // タスクをチェックしようとしたか外そうとしたか
        $is_task_checked = $request->is_task_checked;
        
        // すでにそのタスクにチェックしたか
        $is_task_completed = Complete::select()
                                ->where('task_id','=',$task_id)
                                ->where('user_id','=',$user_id)
                                ->exists();

        if ($is_task_completed && $is_task_checked) {
            try {
                // すでにチェックされている && チェックを外そうとしている => チェックを外す(レコードを物理削除)
                $is_completes_deleted = Complete::where('task_id','=',$task_id)
                                                ->where('user_id','=',$user_id)
                                                ->delete();
            } catch (\Throwable $th) {
                throw new HttpResponseException(response("Server Error.", Response::HTTP_INTERNAL_SERVER_ERROR));
            }

        } elseif (!$is_task_completed && !$is_task_checked) {
            try {
                // まだチェックされていない && チェックをつけようとしている => チェックする(レコードを追加)
                $is_completes_inserted = Complete::insertGetId(
                    [
                        'user_id' => $user_id,
                        'task_id' => $task_id
                    ]
                );
                if (! $is_completes_inserted) {
                    throw new HttpResponseException(response("Server Error.", Response::HTTP_INTERNAL_SERVER_ERROR));
                }
            } catch (\Throwable $th) {
                throw new HttpResponseException(response("Server Error.", Response::HTTP_INTERNAL_SERVER_ERROR));
            }
        } else {
            // completeしたのに追加しようとしている
            // completeしていないのに削除しようとしている
            throw new HttpResponseException(response("You are not allowed",  Response::HTTP_BAD_REQUEST));
        }
    }

}