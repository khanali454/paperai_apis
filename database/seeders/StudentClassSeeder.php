<?php

namespace Database\Seeders;

use App\Models\StudentClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // pakistani classes from 8th to 12th grade
        StudentClass::create([
            'name' => '8th Grade',
            'description' => 'Class for 8th grade students',
            'organized_by' => 1, 
        ]);

        StudentClass::create([
            'name' => '9th Grade',
            'description' => 'Class for 9th grade students',
            'organized_by' => 1,
        ]);
        StudentClass::create([
            'name' => '10th Grade',
            'description' => 'Class for 10th grade students',
            'organized_by' => 1,
        ]);
        StudentClass::create([
            'name' => '11th Grade',
            'description' => 'Class for 11th grade students',
            'organized_by' => 1,
        ]);
        StudentClass::create([
            'name' => '12th Grade',
            'description' => 'Class for 12th grade students',
            'organized_by' => 1,
        ]);

        
    }
}
