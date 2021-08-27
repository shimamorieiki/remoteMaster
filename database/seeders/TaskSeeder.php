<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Grade;
use App\Models\Genre;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 

        // タスクの分類
        $genre_remote_work_tool = Genre::create(['type' => 'remote work tool']);
        $genre_env_design = Genre::create(['type' => 'environmental design']);
        $genre_negative_check = Genre::create(['type' => 'negative check']);

        // 難易度の分類
        $grade_beginner = Grade::create(['type' => 'Beginner']);
        $grade_intermediate = Grade::create(['type' => 'Intermediate']);
        $grade_advanced = Grade::create(['type' => 'Advanced']);
        $grade_bad = Grade::create(['type' => 'bad']);

        // 手打ちするのは大変なのでもしかしたらcsv等を読み込んで動的に取得生成するのもありかもしれない

        // タスク追加
        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 3 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 4 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 5 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_env_design->id,
            'name' => 'clean room',
            'description' => 'clean your room',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_env_design->id,
            'name' => 'clean room',
            'description' => 'clean your room',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 3 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 4 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 5 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_env_design->id,
            'name' => 'clean room',
            'description' => 'clean your room',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_env_design->id,
            'name' => 'clean room',
            'description' => 'clean your room',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 3 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 4 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 5 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_env_design->id,
            'name' => 'clean room',
            'description' => 'clean your room',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_env_design->id,
            'name' => 'clean room',
            'description' => 'clean your room',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 3 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 4 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_remote_work_tool->id,
            'name' => 'PC operation',
            'description' => 'use pc 5 times',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_env_design->id,
            'name' => 'clean room',
            'description' => 'clean your room',
            'is_positive_check' => 1
        ]);

        Task::create([
            'grade_id' => $grade_beginner->id,
            'genre_id' => $genre_env_design->id,
            'name' => 'clean room',
            'description' => 'clean your room',
            'is_positive_check' => 1
        ]);
        
        Task::create([
            'grade_id' => $grade_bad->id,
            'genre_id' => $genre_negative_check->id,
            'name' => 'Cursing out loud',
            'description' => 'Loudly abused a co-worker while at work.',
            'is_positive_check' => 0
        ]);
    }
}