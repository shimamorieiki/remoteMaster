<?php

namespace App\Services;
use App\Http\Requests\TaskRequest;
use App\Models\Vote;
use App\Models\Genre;
use App\Models\User;
use App\Models\Role;
use App\Models\Complete;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use \Symfony\Component\HttpFoundation\Response;

class TaskService
{
    public function add_new_task(Request $request)
    {

        try {
            Task::create(
                [
                    'name' => $request->name,
                    'grade_id' => $request->grade_id,
                    'genre_id' => $request->genre_id,
                    'description' => $request->description,
                    'is_positive_check' => $request->is_positive_check,
                ]
            );
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->serverError());
        }
        
    }

    public function update_task(Request $request)
    {
        
        try {
            Task::where('id','=',$request->id)
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
        } catch (\Throwable $th) {
            throw new HttpResponseException(response()->serverError());
        }
  
    }
}