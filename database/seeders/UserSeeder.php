<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Test User',
            'email' => 'test@email.com', 
            'password' => Hash::make('test@email.com'),
            'email_verified_at' => date('Y-m-d H:i:s'),
            'remember_token' => NULL,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
         DB::table('users')->insert($data);
    }
}
