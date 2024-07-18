<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = collect([
            [
                'name' => 'Zikri Endisyah Munandar',
                'npm' => '51421566',
                'password' => Hash::make('qwertyuiop'),
                'role' => UserRole::Student,
            ],
        ]);

        $users->each(function ($user) {
            User::create($user);
        });
    }

    // public function run() : void
    // {
    //     $csvFile = fopen(base_path("database/seeders/csv/tingkat1.csv"), "r");

    //     $firstline = true;
    //     while (($data = fgetcsv($csvFile, null, ",")) !== FALSE) {
    //         if (! $firstline) {
    //             $user[] = [
    //                 'sub_district_id' => $data[0],
    //                 'nik' => $data[1],
    //                 'name' => $data[2],
    //                 'pob' => $data[3],
    //                 'dob' => $data[4],
    //                 'gender' => $data[5],
    //                 'address' => $data[6],
    //                 'rt' => $data[7],
    //                 'rw' => $data[8],
    //                 'tps' => $data[9],
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];
    //         }
    //         $firstline = false;
    //     }

    //     fclose($csvFile);

    //     foreach (array_chunk($user, 1000) as $chunk) {
    //         User::insert($chunk);
    //     }

    // }
}
