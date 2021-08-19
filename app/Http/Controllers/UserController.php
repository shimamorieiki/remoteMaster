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

class UserController extends Controller
{

   // 特にログイン情報を使用することなくログインを行う
   public function get_user_info()
   {    
        // ユーザ情報を取得
        // 本来ならaccesstokenなどで認証して取得する
        $user = User::select()->where('name','=','jiro')->first();

        // 達成したカラムを取得する
        $completes = Complete::select()
        ->where('user_id','=',$user->id)
        ->get()
        ->pluck("task_id")
        ->all();
        
        // 全てのタスクを取得する
        // grades.typeやgenre.typeを同時に取得する
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
        // コメント

        $STATUSCODE = 200;
        $value = [
            'response' => $tasks
        ];
        return response()->json(
            $value, 
            $STATUSCODE, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
   }
//     //　ログインの実装方針によっては使わないかもしれない｀
//    public function get_users_with_token(Request $request)
//    {    
//         $access_token = $request->input('access_token');
//         if (empty($access_token)) {
//             $STATUSCODE = 400;
//             $value = [
//                 'response' => "not authorized"
//             ];
//         }else {
//             $users = new User();
//             $user = $users -> select('name', 'email')->where('name','=',$access_token)->get();
//             if (empty($user) or count($user) == 0) {
//                 $STATUSCODE = 400;
//                 $value = [
//                     'response' => "not authorized"
//                 ];
//             } else {
//                 $STATUSCODE = 200;
//                 $value = [
//                     'response' => $user,
//                     'token' => $access_token
//                 ];
//             }
//         }
        
//         return response()->json(
//             $value, 
//             $STATUSCODE, 
//             ['Content-Type' => 'application/json'],
//             JSON_UNESCAPED_SLASHES
//         );
//    }

//     // ヘッダー情報を用いてログインする
//     // ログインの実装方針によっては使わないかもしれない｀
//    public function get_users_with_token_header(Request $request)
//    {    
//         $access_token = $request->header('Authorization');
//         $STATUSCODE = 200;
//         $value = [
//             'response' => $user,
//             'token' => $access_token
//         ];
//         return response()->json(
//             $value, 
//             $STATUSCODE, 
//             ['Content-Type' => 'application/json'],
//             JSON_UNESCAPED_SLASHES
//         );
//    }

    // completeしたタスクを送信する
   public function post_completed_task(Request $request)
   {    

        $comment_deny = "denied";
        $comment_accept = "accepted";
       
       // user_idは本当はアクセストークンから取得したい 
        $user_id = User::select('id')->where('name','=',"taro")->get()->first()->id;
       
        $request_json = json_decode($request->getContent(),true);
        // チェックしたタスクのid
        $task_id = $request_json["task_id"];
        
        // 命名規則がわかりにくい
        // タスクをチェックしようとしたか外そうとしたか
        $is_task_checked = $request_json["is_task_checked"];
        
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
                $STATUSCODE = 200;
                $comment = $comment_accept;
            } else {
                $STATUSCODE = 500;
                $comment = $comment_deny;
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
                $STATUSCODE = 200;
                $comment = $comment_accept;
            } else {
                $STATUSCODE = 500;
                $comment = $comment_deny;
            }
        } else {
            // completeしたのに追加しようとしている
            // completeしていないのに削除しようとしている
            $STATUSCODE = 400;
            $comment = $comment_deny;
        }
        $value =[
            'comment' => $comment
        ];
        return response()->json(
            $value, 
            $STATUSCODE, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
   }
}