<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssistantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $users = collect([
            [
                'name' => 'Zikri Endisyah Munandar - Assisten',
                'npm' => '51421566',
                'password' => Hash::make('qwertyuiop'),
                'role' => UserRole::Assistant,
            ],
            [
                'name' => 'Hauzan Dini Fakhri - Assisten',
                'npm' => '51421567',
                'password' => Hash::make('qwertyuiop'),
                'role' => UserRole::Assistant,
            ],
        ]);

        $users->each(function ($user) {
            User::create($user);
        });
    }
}
