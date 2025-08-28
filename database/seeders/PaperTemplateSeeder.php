<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaperTemplateSeeder extends Seeder
{
    public function run()
    {
        // Example User (teacher) who creates templates
        $teacherId = 1; // assuming User ID 1 is a teacher

        // ================================
        // 1. Template: MCQ Only (10 MCQs)
        // ================================
        $template1 = DB::table('paper_templates')->insertGetId([
            'title' => 'MCQ Only (10 Questions)',
            'created_by' => $teacherId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('paper_template_sections')->insert([
            'title' => 'Section A: Multiple Choice',
            'description' => 'Answer all multiple choice questions.',
            'template_id' => $template1,
            'question_type_id' => 1, // Multiple Choice Questions
            'number_of_questions' => 10,
            'number_of_compulsory_questions' => 10,
            'marks_per_question' => 1,
            'order' => 1,
            'is_optional' => false,
            'has_sub_types' => false,
            'instructions' => 'Choose the best option.',
            'tags' => 'mcq,objective',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ======================================
        // 2. Template: 5 MCQs + 5 Short Answers
        // ======================================
        $template2 = DB::table('paper_templates')->insertGetId([
            'title' => 'MCQ + Short Mix',
            'created_by' => $teacherId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('paper_template_sections')->insert([
            [
                'title' => 'Section A: Multiple Choice',
                'description' => 'Select one correct answer.',
                'template_id' => $template2,
                'question_type_id' => 1, // MCQ
                'number_of_questions' => 5,
                'number_of_compulsory_questions' => 5,
                'marks_per_question' => 1,
                'order' => 1,
                'is_optional' => false,
                'has_sub_types' => false,
                'instructions' => 'Each MCQ carries 1 mark.',
                'tags' => 'mcq',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Section B: Short Answers',
                'description' => 'Answer briefly in 2–3 sentences.',
                'template_id' => $template2,
                'question_type_id' => 4, // Short Answer
                'number_of_questions' => 5,
                'number_of_compulsory_questions' => 5,
                'marks_per_question' => 2,
                'order' => 2,
                'is_optional' => false,
                'has_sub_types' => false,
                'instructions' => 'Keep answers concise.',
                'tags' => 'short',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // =========================================
        // 3. Template: 5 Short + 2 Long Questions
        // =========================================
        $template3 = DB::table('paper_templates')->insertGetId([
            'title' => 'Short & Long Questions',
            'created_by' => $teacherId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('paper_template_sections')->insert([
            [
                'title' => 'Section A: Short Questions',
                'description' => 'Answer briefly.',
                'template_id' => $template3,
                'question_type_id' => 4, // Short Answer
                'number_of_questions' => 5,
                'number_of_compulsory_questions' => 5,
                'marks_per_question' => 2,
                'order' => 1,
                'is_optional' => false,
                'has_sub_types' => false,
                'instructions' => 'Max 3–4 lines.',
                'tags' => 'short',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Section B: Long Questions',
                'description' => 'Answer in detail.',
                'template_id' => $template3,
                'question_type_id' => 5, // Long Answer
                'number_of_questions' => 2,
                'number_of_compulsory_questions' => 2,
                'marks_per_question' => 10,
                'order' => 2,
                'is_optional' => false,
                'has_sub_types' => true, // allows sub-questions
                'instructions' => 'Essay style answers required.',
                'tags' => 'long,essay',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // ==========================================
        // 4. Template: Mixed (MCQ + Fill + Short + Long)
        // ==========================================
        $template4 = DB::table('paper_templates')->insertGetId([
            'title' => 'Mixed All Types',
            'created_by' => $teacherId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('paper_template_sections')->insert([
            [
                'title' => 'Section A: MCQs',
                'description' => 'Answer objective questions.',
                'template_id' => $template4,
                'question_type_id' => 1, // MCQ
                'number_of_questions' => 5,
                'number_of_compulsory_questions' => 5,
                'marks_per_question' => 1,
                'order' => 1,
                'is_optional' => false,
                'has_sub_types' => false,
                'instructions' => 'Each MCQ has 4 options.',
                'tags' => 'mcq',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Section B: Fill in the Blanks',
                'description' => 'Complete the missing words.',
                'template_id' => $template4,
                'question_type_id' => 2, // Fill in the Blanks
                'number_of_questions' => 5,
                'number_of_compulsory_questions' => 5,
                'marks_per_question' => 1,
                'order' => 2,
                'is_optional' => false,
                'has_sub_types' => false,
                'instructions' => 'Write exact word.',
                'tags' => 'fill',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Section C: Short Answers',
                'description' => 'Answer in 2–3 lines.',
                'template_id' => $template4,
                'question_type_id' => 4, // Short Answer
                'number_of_questions' => 3,
                'number_of_compulsory_questions' => 3,
                'marks_per_question' => 2,
                'order' => 3,
                'is_optional' => false,
                'has_sub_types' => false,
                'instructions' => 'Keep concise.',
                'tags' => 'short',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Section D: Long Answer',
                'description' => 'Answer in essay style.',
                'template_id' => $template4,
                'question_type_id' => 5, // Long Answer
                'number_of_questions' => 1,
                'number_of_compulsory_questions' => 1,
                'marks_per_question' => 10,
                'order' => 4,
                'is_optional' => false,
                'has_sub_types' => true,
                'instructions' => 'Include examples.',
                'tags' => 'long',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
