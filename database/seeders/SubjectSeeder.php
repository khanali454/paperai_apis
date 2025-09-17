<?php
namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Subject::create([
            'name' => 'Mathematics',
            'description' => 'Mathematics for 8th grade students',
            'class_id' => 1, 
        ]);

        Subject::create([
            'name' => 'Physics',
            'description' => 'Physics for 8th grade students',
            'class_id' => 1,
        ]);

        Subject::create([
            'name' => 'English',
            'description' => 'English for 8th grade students',
            'class_id' => 1, 
        ]);
    }
}
