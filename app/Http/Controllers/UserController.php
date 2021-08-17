<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\User;

class UserController extends Controller
{
   // indexアクションを定義（indexメソッドの定義と同義)
   public function get_users()
   {    
        $users = new User();
        $user = $users -> select('name', 'email')->get();
        // 管理者権限でログインしているなら全てのデータを返す
        $is_user_admin = TRUE;
        if ($is_user_admin) {
            $STATUSCODE = 200;
            $value = [
                'response' => $user
            ];
        } else {
            $STATUSCODE = 404;
            $value = [
                'response' => "404 Error"
            ];
        }
        return response()->json(
            $value, 
            $STATUSCODE, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
   }

   public function get_users_with_token(Request $request)
   {    
        $access_token = $request->input('access_token');
        if (empty($access_token)) {
            $STATUSCODE = 400;
            $value = [
                'response' => "not authorized"
            ];
        }else {
            $users = new User();
            $user = $users -> select('name', 'email')->where('name','=',$access_token)->get();
            if (empty($user) or count($user) == 0) {
                $STATUSCODE = 400;
                $value = [
                    'response' => "not authorized"
                ];
            } else {
                $STATUSCODE = 200;
                $value = [
                    'response' => $user,
                    'token' => $access_token
                ];
            }
        }
        
        return response()->json(
            $value, 
            $STATUSCODE, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
   }
   public function get_users_with_token_header(Request $request)
   {    
        $access_token = $request->header('Authorization');
        $STATUSCODE = 200;
        $value = [
            'response' => $user,
            'token' => $access_token
        ];
        return response()->json(
            $value, 
            $STATUSCODE, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
   }

    // completeしたタスクを送信する
   public function post_completed_task(Request $request)
   {    
        $access_token = $request->input('access_token');
        $request_json = json_decode($request->getContent(),true);
        $task_id = $request_json["task_id"];
        $is_checked = $request_json["task_is_checked"];
        $users = new User();
        $user = $users->select('id')->where('name','=',$access_token)->get();
        $user_id = $user[0]->id;
        // // タスクにチェックをつける
        // if (/*タスクにチェックがついている　&& */) {
        //     $users->select('name', 'email')->where('name','=',$access_token)->get();
        // }
        

        $STATUSCODE = 200;
        $value = [
            'comment' => "ok",
            'task_id' => $task_id,
            'task_id_checked' => $is_checked,
            'user_id' => $user_id
        ];
        
        return response()->json(
            $value, 
            $STATUSCODE, 
            ['Content-Type' => 'application/json'],
            JSON_UNESCAPED_SLASHES
        );
   }
}