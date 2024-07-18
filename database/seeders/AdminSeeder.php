<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $users = collect([
            [
                'name' => 'Admin',
                'email' => 'admin@iflab.gunadarma.ac.id',
                'password' => Hash::make('qwertyuiop'),
                'role' => UserRole::Admin,
            ],
        ]);

        $users->each(function ($user) {
            User::create($user);
        });
    }
}
