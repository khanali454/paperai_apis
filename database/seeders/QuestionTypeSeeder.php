<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypeSeeder extends Seeder
{
    public function run(): void
    {
        $questionTypes = [
            // MCQ - No sub questions
            [
                'name' => 'Multiple Choice Questions',
                'slug' => 'mcq',
                'description' => 'Questions with multiple choices and one correct answer',
                'has_options' => true,
                'has_correct_answer' => true,
                'can_have_sub_questions' => false,
                'has_paragraph' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // True/False - No sub questions
            [
                'name' => 'True/False Questions',
                'slug' => 'true-false',
                'description' => 'Questions with true or false options',
                'has_options' => true,
                'has_correct_answer' => true,
                'can_have_sub_questions' => false,
                'has_paragraph' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Fill in Blanks - No sub questions
            [
                'name' => 'Fill in the Blanks',
                'slug' => 'fill-in-blanks',
                'description' => 'Questions requiring text input with correct answer',
                'has_options' => false,
                'has_correct_answer' => true,
                'can_have_sub_questions' => false,
                'has_paragraph' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Short Answer - Can have sub questions, optional correct answer
            [
                'name' => 'Short Answer Questions',
                'slug' => 'short-answer',
                'description' => 'Short answer questions with optional correct answer',
                'has_options' => false,
                'has_correct_answer' => false, // Optional
                'can_have_sub_questions' => true,
                'has_paragraph' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Long Answer - Can have sub questions, optional correct answer
            [
                'name' => 'Long Answer Questions',
                'slug' => 'long-answer',
                'description' => 'Long answer questions with optional correct answer',
                'has_options' => false,
                'has_correct_answer' => false, // Optional
                'can_have_sub_questions' => true,
                'has_paragraph' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Paragraph Questions - Has paragraph text and sub questions
            [
                'name' => 'Paragraph Questions',
                'slug' => 'paragraph',
                'description' => 'Questions based on a paragraph with sub-questions',
                'has_options' => false,
                'has_correct_answer' => false,
                'can_have_sub_questions' => true,
                'has_paragraph' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Conditional Questions - Has logic and sub questions
            [
                'name' => 'Conditional Questions',
                'slug' => 'conditional',
                'description' => 'Questions with conditional logic (AND/OR) and sub-questions',
                'has_options' => false,
                'has_correct_answer' => false,
                'can_have_sub_questions' => true,
                'has_paragraph' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('question_types')->insert($questionTypes);
    }
}