<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\User;
use App\Models\Role;
use App\Models\Complete;
use App\Models\Task;

class UserController extends Controller
{

   // 特にログイン情報を使用することなくログインを行う
   public function get_user_info()
   {    
        // ユーザ情報を取得
        // 本来ならaccesstokenなどで認証して取得する
        $user = User::select()->where('name','=','taro')->first();


        $role = Role::select()->where('id','=',$user->role_id)->first();
        $completes = Complete::select('task_id')->where('id','=',$user->id)->first();
        $tasks_completed = Task::select()->where('id','=',$completes->task_id)->get();
        $tasks_yet_completed = $tasks_completed;

        // タスクのidを取得し、達成済みか未達成かを判断する
        $user_info = array(
            "name" => $user->name,
            "role" => $role->type,
            "tasks_completed" => $tasks_completed,
            "tasks_yet_completed" => $tasks_yet_completed
        );

        $STATUSCODE = 200;
        $value = [
            'response' => $user_info
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

        $STATUSCODE = 400;
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
                $STATUSCODE = 400;
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
                $STATUSCODE = 400;
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