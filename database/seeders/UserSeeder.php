<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 代入
        $admin_user = Role::create(['type' => 'Admin']);
        $general_user = Role::create(['type' => 'General']);

        // 管理者サンプル
        User::create([
            'name' => 'adm',
            'email' => 'adm@co.jp',
            'password' => bcrypt('pass'),
            'role_id' => $admin_user->id,
        ]);

        // 一般ユーザサンプル
        User::create([
            'name' => 'gen',
            'email' => 'gen@co.jp',
            'password' => bcrypt('word'),
            'role_id' => $general_user->id,
        ]);
    }
}