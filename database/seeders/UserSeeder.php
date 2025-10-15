<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $numberOfUsers = \DB::table('users')->count();
        // user
        if ($numberOfUsers == 0) {

            DB::table('users')->insert([
                'role_id' => 1,
                'name' => 'Railway',
                'mobile' => 2222222222,
                'email' => 'railway@gmail.com',
                'department_id' => null,
                'email_verified_at' => carbon::now(),
                'password' => bcrypt('Railway@1234'),
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);

        }
    }
}
