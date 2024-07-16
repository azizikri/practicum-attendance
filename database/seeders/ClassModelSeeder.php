<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $classes = [];
        for ($prefix = 1; $prefix <= 4; $prefix++) {
            for ($i = 1; $i <= 20; $i++) {
                $classes[] = ['name' => $prefix . 'IA' . str_pad($i, 2, '0', STR_PAD_LEFT), 'created_at' => now()];
            }
        }

        ClassModel::insert($classes);
    }
}
