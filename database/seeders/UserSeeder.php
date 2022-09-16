<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
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
        User::updateOrCreate(
            [
                'id' => 1
            ],
            [
               'name' => 'Abdalrhman Hussin',
               'email' =>'abdalrhmanhussin44@gmail.com',
               'email_verified_at' => Carbon::now(),
               'password' => Hash::make('password'),
               'company_id' => 1,
               'created_at' => Carbon::now(),
               'updated_at' => Carbon::now(),
               'active' => 1,
                'role_id' => 1
            ]
        );
    }
}
