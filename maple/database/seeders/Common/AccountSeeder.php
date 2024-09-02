<?php

namespace Database\Seeders\Common;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = Str::orderedUuid();
        DB::table('admins')->insert(
            [
                'id' => $adminId,
                'name' => 'Admin',
                'email' => 'admin@autumn.io',
                'password' => Hash::make('abcd1234'),
            ]
        );

        $userId = \Str::orderedUuid();
        DB::table('users')->insert(
            [
                'id' => $userId,
                'name' => 'User',
                'email' => 'user@autumn.io',
                'password' => Hash::make('abcd1234'),
            ]
        );

        DB::table('oauth_clients')->insert([
            'id' => Str::orderedUuid(),
            'user_id' => $adminId,
            'name' => 'Public',
            'redirect' => env('OAUTH_CLIENT_CALLBACK', 'http://localhost:8000/oauth/callback'),
            'personal_access_client' => false,
            'password_client' => false,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('oauth_clients')->insert([
            'id' => Str::orderedUuid(),
            'user_id' => $adminId,
            'name' => 'Api [users]',
            'secret' => Str::random(40),
            'provider' => 'users',
            'redirect' => 'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('oauth_clients')->insert([
            'id' => Str::orderedUuid(),
            'user_id' => $adminId,
            'name' => 'Api [admins]',
            'secret' => Str::random(40),
            'provider' => 'admins',
            'redirect' => 'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
