<?php
namespace Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QuestionType::create([
            'name'        => 'Multiple Choice Questions',
            'description' => 'A question with multiple answer options, where only one is correct.',
        ]);

        QuestionType::create([
            'name'        => 'Fill in the Blanks',
            'description' => 'A question where the respondent fills in missing words or phrases.',
        ]);

        QuestionType::create([
            'name'        => 'True/False',
            'description' => 'A question that can be answered with either true or false.',
        ]);

        QuestionType::create([
            'name'        => 'Short Answer',
            'description' => 'A question that requires a brief written response.',
        ]);

        QuestionType::create([
            'name'        => 'Long Answer',
            'description' => 'A question that requires a detailed written response.',
        ]);

    }
}
