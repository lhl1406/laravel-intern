<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $userList = [
            [
                'name' => 'Director',
                'email' => 'user0@gmail.com',
                'password' => Hash::make('password'),
                'group_id' =>  1,
                'started_date' => now(),
                'position_id' => 0,
                'created_date' => now(),
                'updated_date' => now(),
            ],
            [
                'name' => 'Group leader',
                'email' => 'user1@gmail.com',
                'password' => Hash::make('password'),
                'group_id' =>  1,
                'started_date' => now(),
                'position_id' => 1,
                'created_date' => now(),
                'updated_date' => now(),
            ],
            [
                'name' => 'Leader',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('password'),
                'group_id' =>  1,
                'started_date' => now(),
                'position_id' => 2,
                'created_date' => now(),
                'updated_date' => now(),
            ],
            [
                'name' => 'Member',
                'email' => 'user3@gmail.com',
                'password' => Hash::make('password'),
                'group_id' =>  1,
                'started_date' => now(),
                'position_id' => 3,
                'created_date' => now(),
                'updated_date' => now(),
            ],
        ];

        DB::table('user')->insert($userList);

        $groupList = [
            [
                'name' => 'Group first',
                'group_floor_number' => 4,
                'group_leader_id' => 1,
                'created_date' => now(),
                'updated_date' => now(),
            ],
        ];

        DB::table('group')->insert($groupList);
    }
}
