<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => '管理者',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$tySIrWuYcOjZmQQ6WOERu.wk1JOmOIiQ5TboOs0eijrTA/nJ1DDzG',
                'remember_token' => null,
                'created_at'     => '2020-04-09 09:53:12',
                'updated_at'     => '2020-04-09 09:53:12',
            ],
        ];

        User::insert($users);
    }
}
