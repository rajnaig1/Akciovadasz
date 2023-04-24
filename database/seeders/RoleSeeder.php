<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('Roles')->delete();
        $roles = [
            [
                '_id' => 1,
                'role' => 'dev'
            ], [
                '_id' => 2,
                'role' => 'admin'
            ], [
                '_id' => 3,
                'role' => 'user'
            ],
        ];
        DB::table('Roles')->insert($roles);
    }
}
