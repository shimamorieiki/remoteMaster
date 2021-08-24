<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;
    use RefreshDatabase;
    
    // public function setUp(): void
    // {
    //     parent::setUp();
    // }

    // public function test_get_user_info()
    // {
        
    //     // ログインする
    //     Sanctum::actingAs(
    //         User::create(["ユーザ情報の配列"]),
    //         ['*']
    //     );
    
    //     // $response = $this->get('/api/task');

    //     // ログイン情報を利用してgetリクエスト飛ばす
    //     $response = $this->get(route('users.get_user_info'));

    //     // Taskテーブルのレコード数
    //     // $tasks_num = 

    //     // レスポンスの検証
    //     $response->assertOk() # ステータスコードが 200
    //         ->assertJsonCount(1 /* $tasks_num */) # レスポンスの配列の件数がtasksテーブルのレコード数
    //         // レスポンスで返ってきたものが全て一致する
    //         ->assertJsonFragment([ # レスポンスJSON に以下の値を含む
    //             'email' => 'user1@example.com',
    //         ]);
    // }

    // public function post_completed_task()
    // {
        
    //     // ログインする
        
    //     // ログイン情報を利用してgetリクエスト飛ばす

    //     $data1 = [ # 登録用のデータ
    //         'task_id' => 1,
    //         'is_task_checked' => FALSE
    //     ];
        
    //     $data2 = [ # 登録用のデータ
    //         'task_id' => 1,
    //         'is_task_checked' => TRUE
    //     ];


    //     // 投票する前
    //     // まだチェックしてなくてチェックしようとする
    //     $response1 = $this->post(route('users.get_user_info'), $data1);
    //     $response1->assertOk();

    //     // チェックしていてチェックしようとする
    //     $response2 = $this->post(route('users.get_user_info'), $data1);
    //     $response2->assertOk();
        
    //     // チェックしていて外そうとする
    //     $response3 = $this->post(route('users.get_user_info'), $data2);
    //     $response3->assertOk();

    //     // チェックしていなくてチェックを外そうとする
    //     $response4 = $this->post(route('users.get_user_info'), $data2);
    //     $response4->assertOk();

    //     // 投票後
    //     // まだチェックしてなくてチェックしようとする
    //     $response5 = $this->post(route('users.get_user_info'), $data1);
    //     $response5->assertOk();

    //     // チェックしていて外そうとする
    //     $response6 = $this->post(route('users.get_user_info'), $data1);
    //     $response6->assertOk();

    //     // チェックしていてチェックしようとする
    //     $response7 = $this->post(route('users.get_user_info'), $data2);
    //     $response7->assertOk();
        
    //     // チェックしていなくてチェックを外そうとする
    //     $response8 = $this->post(route('users.get_user_info'), $data2);
    //     $respons8->assertOk();
    // }
}
