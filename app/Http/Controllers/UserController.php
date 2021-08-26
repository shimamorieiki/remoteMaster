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
use App\Services\UserService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userservice)
    {
        $this->userService = $userservice;
    }

   // ユーザ情報を取得する
   public function get_user_info(Request $request)
   {    

        try {
            $tasks = $this->userService->get_user_info($request->user()->id);
            return response()->json($tasks, Response::HTTP_OK);
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }
   }

    // completeしたタスクを送信する
   public function post_completed_task(Request $request)
   {    

        $user_id = $request->user()->id;
        try {
            // タスクにチェックできるか判定する
            $this->userService->canVote($user_id);
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }

        try {
            // completeしたタスクを送信する
            $this->userService->post_completed_task($request);
            return response()->json('Accepted', Response::HTTP_OK);
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }

   }
}