<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // questiontype seeder
        $this->call(UserSeeder::class);
        $this->call(StudentClassSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(QuestionTypeSeeder::class);
        $this->call(PaperTemplateSeeder::class);
        $this->call(StudyMaterialSeeder::class);

        
    }
}
