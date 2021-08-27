<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Complete;

class CompleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 

        // 達成状況追加
        for ($i=1; $i < 15; $i++) { 
            Complete::create([
                'user_id' => 2,
                'task_id' => $i,
            ]);
        }
    }
}