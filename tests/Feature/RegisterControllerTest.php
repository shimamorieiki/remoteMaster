<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class RegisterControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_register()
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
                
        $test_user = [
            'name' => 'test',
            'email' => 'test@co.jp',
            'password' => "test",
            'role_id' => 2,
        ];

        // ログイン情報を利用してpostリクエストを飛ばす
        // 管理者ユーザなら結果を取得できる
        $response1 = $this->actingAs($user_admin)->post('api/register',$test_user);
        $response1->assertOk();

        // 一般ユーザなら結果を取得できない
        $response2 = $this->actingAs($user_general)->post('api/register',$test_user);
        $response2->assertStatus(400);
    }
}
