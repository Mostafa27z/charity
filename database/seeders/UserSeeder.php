<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'association_id' => 1,
                'name'           => 'أحمد علي',
                'email'          => 'ahmed.admin@example.com',
                'phone'          => '01055555551',
                'password'       => Hash::make('12345678'),
                'role'           => 'admin',
                'status'         => 'active',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'association_id' => 1,
                'name'           => 'منى محمد',
                'email'          => 'mona.user@example.com',
                'phone'          => '01055555552',
                'password'       => Hash::make('12345678'),
                'role'           => 'user',
                'status'         => 'active',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'association_id' => 2,
                'name'           => 'خالد سعيد',
                'email'          => 'khaled.admin@example.com',
                'phone'          => '01055555553',
                'password'       => Hash::make('12345678'),
                'role'           => 'admin',
                'status'         => 'active',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'association_id' => 2,
                'name'           => 'سارة حسن',
                'email'          => 'sara.user@example.com',
                'phone'          => '01055555554',
                'password'       => Hash::make('12345678'),
                'role'           => 'user',
                'status'         => 'active',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'association_id' => 3,
                'name'           => 'ليلى أحمد',
                'email'          => 'laila.admin@example.com',
                'phone'          => '01055555555',
                'password'       => Hash::make('12345678'),
                'role'           => 'admin',
                'status'         => 'active',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ]);
    }
}
