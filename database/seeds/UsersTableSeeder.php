<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_name' => 'Admin',
            'user_password' => bcrypt('ujjain@0734'),
            'user_display_name' => 'Hd.Admin',
            'user_status' => 1,
            'user_level' => 1,
        ]);
    }
}
