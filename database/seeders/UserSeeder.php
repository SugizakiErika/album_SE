<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $params = 
        [
            [
                'id' => 1,
                'name' => 'Sugizaki',
                'email' => env('MAIL_USERNAME'),
                'password' => Hash::make(env('MAIL_MY_PASSWORD')),
                //'role' => 'administrator'
            ]
        ];
        
        foreach ($params as $param) {
        DB::table('users')->insert($param);
        }
    }
}
