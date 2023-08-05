<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::truncate(); 
           $users = [ 
            [ 
              'name' => 'Admin',
              'email' => 'admin@hotelkey.com',
              'password' => 'admin@123',
              'user_type' => 'admin',
            ]
          ];

          foreach($users as $user)
          {
            $id = \App\Models\User::create([
               'name' => $user['name'],
               'email' => $user['email'],
               'user_type' => 'admin',
               'password' => Hash::make($user['password'])
             ]);

              \App\Models\UserDetails::create([
              'user_id' => $id->id ,
              'first_name' => $user['name'],
            ]);
           }
    }
}
