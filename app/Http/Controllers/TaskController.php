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
use App\Services\TaskService;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskController extends Controller
{
    private $taskService;

    public function __construct(TaskService $taskservice)
    {
        $this->taskService = $taskservice;
    }

   // 管理者が新しいタスクを追加する
   public function add_new_task(TaskRequest $request)
   {

       try {
            // 一般ユーザは追加できない
            $request->user()->must_be_Admin();
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }

        try {
            // 新しいタスクを追加する
            $this->taskService->add_new_task($request);
            return response()->json('Accepted', Response::HTTP_OK);
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }

   }

    // タスクの一部を変更する
   public function update_task(Request $request)
   {    
       try {
            // 一般ユーザは変更できない
            $request->user()->must_be_Admin();
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }

        try {
            // タスクを更新する
            $this->taskService->update_task($request);
            return response()->json('Accepted', Response::HTTP_OK);
        } catch (HttpResponseException $he) {
            return response()->json(
                $he->getResponse()->original,
                $he->getResponse()->status()
            );
        }
    }
}