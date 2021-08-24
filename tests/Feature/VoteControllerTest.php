<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;
    // public function setUp(): void
    // {
    //     parent::setUp();
    // }

    // public function test_get_winner()
    // {
    //     // インサートするテーブルをこっちで決めればいいのか
    //     // テーブルだけ作っておいてシーディングをここからする
        
    //     // ログインする
        
        
        
    //     // ログイン情報を利用してgetリクエスト飛ばす
    //     $response = $this->get(route('users.get_winner'));
    //     // レスポンスの検証
    //     // 勝者が存在するとき
    //     $response->assertOk() # ステータスコードが 200
    //         ->assertJsonCount(1) # レスポンスの配列の件数がtasksテーブルのレコード数
    //         // レスポンスで返ってきたものが全て一致する
    //         ->assertJsonFragment([ # レスポンスJSON に以下の値を含む
    //             'name' => '', // ここでシーディングしていれば答えの人間と数字を決め打ちできる
    //             'voting_number' => '', // ここでシーディングしていれば答えの人間と数字を決め打ちできる
    //         ]);

    //     // 勝者が存在しないとき
    //     $response->assertOk() # ステータスコードが 200
    //         ->assertJsonCount(1) # レスポンスの配列の件数がtasksテーブルのレコード数
    //         // レスポンスで返ってきたものが全て一致する
    //         ->assertJsonFragment([ # レスポンスJSON に以下の値を含む
    //             'name' => '', // ここでシーディングしていれば答えの人間と数字を決め打ちできる
    //             'voting_number' => '', // ここでシーディングしていれば答えの人間と数字を決め打ちできる
    //         ]);

    //     // 回答を確認する権限がないとき
    //     $response->assertOk(); # ステータスコードが 200
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
