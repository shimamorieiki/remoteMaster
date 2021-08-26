<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Task;
use App\Models\Vote;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_user_info()
    {
        
        // テストログイン用のユーザー作成
        $email = 'testadmin@co.com';
        $password = 'pass';
        
        // 同名のユーザを削除
        User::where('email', $email)->delete();

        // テストユーザ作成
        $user = User::create([
            'name' => 'TestAdm',
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => 1,
        ]);
        
        
        // ログインする
        $response = $this->actingAs($user)
                        ->get('api/user');
        
        // Taskの個数を取得する
        $tasks_num = Task::select()->count();

        $response->assertOk() // ステータスコードが 200
                ->assertJsonCount($tasks_num); // Taskテーブルのレコード数と一致
        
        // 戻り値が正しいかどうかを判断する。
        // Tasksの個数を全部取得できていれば問題ない気もする。
        // とりあえず中身を見るのは後回しにする。

        // 作ったユーザを削除する
        User::where('email', $email)->delete();
    }

    public function test_post_completed_task()
    {

        // テストログイン用のユーザー作成
        $email = 'testadmin@co.com';
        $password = 'pass';
        
        // 同名のユーザを削除
        User::where('email', $email)->delete();

        // テストユーザ作成
        $user = User::create([
            'name' => 'TestAdm',
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => 1,
        ]);
        

        $data1 = [ # 登録用のデータ
            'task_id' => 1,
            'is_task_checked' => FALSE
        ];
        
        $data2 = [ # 登録用のデータ
            'task_id' => 1,
            'is_task_checked' => TRUE
        ];


        // 投票する前
        // まだチェックしてなくてチェックしようとする
        $response1 = $this->actingAs($user)->post('api/user',$data1);
        $response1->assertOk();

        // チェックしていてチェックしようとする
        $response2 = $this->actingAs($user)->post('api/user',$data1);
        $response2->assertStatus(400);
        
        // チェックしていて外そうとする
        $response3 = $this->actingAs($user)->post('api/user', $data2);
        $response3->assertOk();

        // チェックしていなくてチェックを外そうとする
        $response4 = $this->actingAs($user)->post('api/user', $data2);
        $response4->assertStatus(400);

        // 投票する
        Vote::create([
            'user_id' => $user->id,
            'voting_number' => 100
        ]);

        // 投票後
        // まだチェックしてなくてチェックしようとする
        $response5 = $this->actingAs($user)->post('api/user', $data1);
        $response5->assertStatus(400);

        // チェックしていて外そうとする
        $response6 = $this->actingAs($user)->post('api/user', $data1);
        $response6->assertStatus(400);

        // チェックしていてチェックしようとする
        $response7 = $this->actingAs($user)->post('api/user', $data2);
        $response7->assertStatus(400);
        
        // チェックしていなくてチェックを外そうとする
        $response8 = $this->actingAs($user)->post('api/user', $data2);
        $response8->assertStatus(400);

        // 同名のユーザを削除
        User::where('email', $email)->delete();
    }
}
