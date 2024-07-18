<?php

namespace Database\Seeders;

use App\Enums\AcademicPeriod;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        settings()->set('academic_year', '2023/2024');
        settings()->set('academic_period', AcademicPeriod::ATA);

        $this->call([
            ClassModelSeeder::class,
            SubjectSeeder::class,
            ClassSubjectSeeder::class,
            AdminSeeder::class,
            AssistantSeeder::class,
            StudentSeeder::class,
        ]);


    }
}
