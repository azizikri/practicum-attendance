<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $subjects = collect([
            [
                'name' => 'Dasar Komputer dan Pemrograman',
            ],
            [
                'name' => 'Algoritma Pemrograman 3B',
            ],
            [
                'name' => 'Kecerdasan Artifisial',
            ],
            [
                'name' => 'Jaringan Komputer',
            ],
            [
                'name' => 'Perancangan Analisis Algoritma',
            ],
            [
                'name' => 'Pemrograman Web',
            ],
            [
                'name' => 'Interaksi Manusia Komputer',
            ],
            [
                'name' => 'Grafik Komputer',
            ],
            [
                'name' => 'Sistem Basis Data',
            ],
            [
                'name' => 'Pemrograman Jaringan',
            ],
            [
                'name' => 'Rekayasan Perangkat Lunak',
            ],
        ]);

        $subjects->each(function ($subject) {
            Subject::create($subject);
        });
    }
}
