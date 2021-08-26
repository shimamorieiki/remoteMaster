<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class TaskControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_add_new_task()
    {
        
        // テストログイン用の管理者ユーザー作成
        $email = 'testadmin@co.jp';
        $password = 'pass';
        
        // 同名のユーザを削除
        User::where('email', $email)->delete();

        // テストユーザ作成
        $user_admin = User::create([
            'name' => 'TestAdm',
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => 1,
        ]);
        
        // テストログイン用の一般ユーザー作成
        $email = 'testgeneral@co.jp';
        $password = 'word';
        
        // 同名のユーザを削除
        User::where('email', $email)->delete();

        // テストユーザ作成
        $user_general = User::create([
            'name' => 'Testgen',
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => 2,
        ]);
                
        
        // ログイン情報を利用してgetリクエスト飛ばす
        // 管理者ユーザなら結果を取得できる
        $task = [
            'name'=> '$testTask',
            'grade_id'=>1,
            'genre_id'=>1,
            'description'=>'$TestDescription',
            'is_positive_check'=>true
        ];

        $response1 = $this->actingAs($user_admin)->post('api/task',$task);
        $response1->assertOk();

        // 取得した結果が正しいかをこれから見る

        // 一般ユーザなら結果を取得できない
        $response2 = $this->actingAs($user_general)->post('api/task',$task);
        $response2->assertStatus(400);
    }

    public function test_renew_task()
    {
        
        // テストログイン用の管理者ユーザー作成
        $email = 'testadmin@co.jp';
        $password = 'pass';
        
        // 同名のユーザを削除
        User::where('email', $email)->delete();

        // テストユーザ作成
        $user_admin = User::create([
            'name' => 'TestAdm',
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => 1,
        ]);
        
        // テストログイン用の一般ユーザー作成
        $email = 'testgeneral@co.jp';
        $password = 'word';
        
        // 同名のユーザを削除
        User::where('email', $email)->delete();

        // テストユーザ作成
        $user_general = User::create([
            'name' => 'Testgen',
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => 2,
        ]);
        

        // テストタスク作成
        $test_task = Task::create([
            'name'=> 'nameBef',
            'grade_id'=>1,
            'genre_id'=>1,
            'description'=>'descriptionBef',
            'is_positive_check'=> true
        ]);
        
        // 変更するダミータスク
        $task = [
            'id' => $test_task->id,
            'name'=> 'nameAft',
            'grade_id'=>2,
            'genre_id'=>2,
            'description'=>'descriptionAft',
            'is_positive_check'=> true
        ];
        
        // 管理者ユーザならタスクを変更できる
        $response1 = $this->actingAs($user_admin)->put('api/task',$task);
        $response1->assertOk();

        // 取得した結果が正しいかをこれから見る

        // 一般ユーザならタスクを変更できない
        $response2 = $this->actingAs($user_general)->put('api/task',$task);
        $response2->assertStatus(400);
    }
}
