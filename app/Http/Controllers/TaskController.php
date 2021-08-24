<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\User;
use App\Models\Role;
use App\Models\Vote;
use App\Models\Complete;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use \Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{

   // 管理者が新しいタスクを追加する
   public function add_new_task(Request $request)
   {

        // $role = (1,管理者),(2,一般ユーザ)
        // 一般ユーザは追加できない
        $general_role_id = 2;
        if ($request->user()->role_id == $general_role_id) {
            return response()->json('You are not allowed.', Response::HTTP_BAD_REQUEST);
        }

        Task::create(
            [
                'name' => $request->name,
                'grade_id' => $request->grade_id,
                'genre_id' => $request->genre_id,
                'description' => $request->description,
                'is_positive_check' => $request->is_positive_check,
            ]
        );
        return response()->json('Accepted', Response::HTTP_OK);
   }

    // タスクの一部を変更する
   public function update_task(Request $request)
   {    
        // $role = (1,管理者),(2,一般ユーザ)
        // 一般ユーザは追加できない
        $general_role_id = 2;
        if ($request->user()->role_id == $general_role_id) {
            return response()->json('You are not allowed.', Response::HTTP_BAD_REQUEST);
        }

        // リクエストに与えられないカラムがあればnull値に変更する
        // nullに変更するのは "" だと空文字で更新される心配がある。
        // foreach ($request as $key => $value) {
        //     if ($value->isEmpty()){
        //         $value = null;
        //     }
        // }

        // $is_task_changed = DB::raw('UPDATE TABLE SET NAME = (CASE WHEN :newName IS NOT NULL THEN :newName ELSE NAME END),
        //     AGE  = (CASE WHEN :newAge IS NOT NULL THEN :newAge ELSE AGE END),
        //     DESCRIPTION  = (CASE WHEN :newDescription IS NOT NULL THEN :newDescription ELSE DESCRIPTION END) WHERE ID = :id;')
        $is_task_changed = Task::where('id','=',$request->id)
            ->first()
            ->update(
                [
                    'name' => $request->name,
                    'grade_id' => $request->grade_id,
                    'genre_id' => $request->genre_id,
                    'description' => $request->description,
                    'is_positive_check' => $request->is_positive_check,
                ]
            );

        if ($is_task_changed) {
            return response()->json('Accepted', Response::HTTP_OK);
        } else {
            return response()->json('Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
   }
}