<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\ClassModel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $freshmans = ClassModel::where('name', 'like', '1IA%')->get();

        $sophomores = ClassModel::where('name', 'like', '2IA%')->get();
        $sophomoreSubjects = Subject::where('id', 2)->get();

        $juniors = ClassModel::where('name', 'like', '3IA%')->get();
        $juniorSubjects = Subject::whereIn('id', [3, 4, 5, 6, 7, 8, 9])->get();

        $seniors = ClassModel::where('name', 'like', '4IA%')->get();
        $seniorSubjects = Subject::whereIn('id', [10, 11])->get();

        foreach ($sophomores as $sophomore) {
            foreach ($sophomoreSubjects as $subject) {
                $sophomore->subjects()->attach($subject->id, [
                    'class_name' => $sophomore->name,
                    'subject_name' => $subject->name,
                    'subject_short_name' => $subject->short_name
                ]);
            }
        }

        foreach ($juniors as $junior) {
            foreach ($juniorSubjects as $subject) {
                $junior->subjects()->attach($subject->id, [
                    'class_name' => $junior->name,
                    'subject_name' => $subject->name,
                    'subject_short_name' => $subject->short_name
                ]);
            }
        }

        foreach ($seniors as $senior) {
            foreach ($seniorSubjects as $subject) {
                $senior->subjects()->attach($subject->id, [
                    'class_name' => $senior->name,
                    'subject_name' => $subject->name,
                    'subject_short_name' => $subject->short_name
                ]);
            }
        }
    }
}
