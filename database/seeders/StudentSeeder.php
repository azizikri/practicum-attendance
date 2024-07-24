<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\ClassModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $users = collect([
    //         [
    //             'name' => 'Zikri Endisyah Munandar',
    //             'npm' => '51421566',
    //             'password' => Hash::make('qwertyuiop'),
    //             'role' => UserRole::Student,
    //         ],
    //     ]);

    //     $users->each(function ($user) {
    //         User::create($user);
    //     });
    // }

    public function run() : void
    {
        $csvFile = fopen(base_path("database/seeders/csv/tingkat1.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, null, ",")) !== FALSE) {
            if (! $firstline) {
                $user[] = [
                    'name' => $data[0],
                    'npm' => $data[1],
                    'email' => $data[1].'@iflab.gunadarma.ac.id',
                    'class_id' => ClassModel::where('name',$data[2])->firstOrFail()->id,
                    'password' => Hash::make($data[3]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $firstline = false;
        }

        fclose($csvFile);

        foreach (array_chunk($user, 100) as $chunk) {
            User::insert($chunk);
        }

    }
}
