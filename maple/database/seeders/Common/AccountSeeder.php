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
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $userId = \Str::orderedUuid();
        DB::table('users')->insert(
            [
                'id' => $userId,
                'name' => 'User',
                'email' => 'user@autumn.io',
                'password' => Hash::make('abcd1234'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('oauth_clients')->insert([
            'id' => config('oauth.client_id'),
            'user_id' => $adminId,
            'name' => 'Public',
            'redirect' => config('oauth.client_callback'),
            'personal_access_client' => false,
            'password_client' => false,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('oauth_clients')->insert([
            'id' => config('oauth.user.client_id'),
            'user_id' => $adminId,
            'name' => 'Api [users]',
            'secret' => config('oauth.user.client_secret'),
            'provider' => 'users',
            'redirect' => 'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('oauth_clients')->insert([
            'id' => config('oauth.admin.client_id'),
            'user_id' => $adminId,
            'name' => 'Api [admins]',
            'secret' => config('oauth.admin.client_secret'),
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
