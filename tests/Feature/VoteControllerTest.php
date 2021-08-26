<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class VoteControllerTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_get_winner()
    {
        // インサートするテーブルをこっちで決めればいいのか
        // テーブルだけ作っておいてシーディングをここからする
        
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
        $response1 = $this->actingAs($user_admin)->get('api/lottery');
        $response1->assertOk();

        // 取得した結果が正しいかをこれから見る

        // 一般ユーザなら結果を取得できない
        $response2 = $this->actingAs($user_general)->get('api/lottery');
        $response2->assertStatus(400);

        // レスポンスの検証
        // 勝者が存在するとき
        // $response->assertOk() # ステータスコードが 200
        //     ->assertJsonCount(1) # レスポンスの配列の件数がtasksテーブルのレコード数
        //     // レスポンスで返ってきたものが全て一致する
        //     ->assertJsonFragment([ # レスポンスJSON に以下の値を含む
        //         'name' => '', // ここでシーディングしていれば答えの人間と数字を決め打ちできる
        //         'voting_number' => '', // ここでシーディングしていれば答えの人間と数字を決め打ちできる
        //     ]);

        // // 勝者が存在しないとき
        // $response->assertOk() # ステータスコードが 200
        //     ->assertJsonCount(1) # レスポンスの配列の件数がtasksテーブルのレコード数
        //     // レスポンスで返ってきたものが全て一致する
        //     ->assertJsonFragment([ # レスポンスJSON に以下の値を含む
        //         'name' => '', // ここでシーディングしていれば答えの人間と数字を決め打ちできる
        //         'voting_number' => '', // ここでシーディングしていれば答えの人間と数字を決め打ちできる
        //     ]);
    }

    public function test_vote()
    {
        
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

        // テストユーザ作成1
        $user_general = User::create([
            'name' => 'Testgen',
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => 2,
        ]);

        // 管理者権限ユーザは投票できない
        $response1 = $this->actingAs($user_admin)->post('api/lottery',['voting_number'=>$user_admin->id]);
        $response1->assertStatus(400);

        // 一般ユーザは投票できる
        
        // // 投票できた
        // $response2 = $this->actingAs($user_general)->post('api/lottery',['voting_number'=>$user_general->id]);


        // // バリデーションエラーに引っかかる
        // $response2 = $this->actingAs($user_general)->post('api/lottery',['voting_number'=>$user_general->id]);
        
        // タスクを15個以上こなしていない
        $response2 = $this->actingAs($user_general)->post('api/lottery',['voting_number'=>$user_general->id]);
        $response1->assertStatus(400);

        // // ネガティブチェックがある
        // $response2 = $this->actingAs($user_general)->post('api/lottery',['voting_number'=>$user_general->id]);

        // // すでに投票している
        // $response2 = $this->actingAs($user_general)->post('api/lottery',['voting_number'=>$user_general->id]);

    }
}
