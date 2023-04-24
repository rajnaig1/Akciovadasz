<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->delete();
        $users = [
            [
                'name' => 'dev',
                'email' => 'dev@dev.hu',
                'password' => password_hash('dev', PASSWORD_BCRYPT),
                'role_id' => 1
            ], [
                'name' => 'admin',
                'email' => 'admin@admin.hu',
                'password' => password_hash('admin', PASSWORD_BCRYPT),
                'role_id' => 2
            ], [
                'name' => 'user',
                'email' => 'user@user.hu',
                'password' => password_hash('user', PASSWORD_BCRYPT),
                'role_id' => 3
            ],
        ];
        DB::table('users')->insert($users);
    }
}
