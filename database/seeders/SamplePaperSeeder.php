<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SamplePaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // Get question type IDs
        $mcqTypeId = DB::table('question_types')->where('slug', 'mcq')->value('id');
        $trueFalseTypeId = DB::table('question_types')->where('slug', 'true-false')->value('id');
        $fillBlanksTypeId = DB::table('question_types')->where('slug', 'fill-in-blanks')->value('id');
        $shortAnswerTypeId = DB::table('question_types')->where('slug', 'short-answer')->value('id');
        $longAnswerTypeId = DB::table('question_types')->where('slug', 'long-answer')->value('id');
        $paragraphTypeId = DB::table('question_types')->where('slug', 'paragraph')->value('id');

        // Get sample user, class, and subject IDs (assuming these exist)
        $userId = 1;
        $classId = 1;
        $englishSubjectId = 3;
        $mathSubjectId = 1;
        $physicsSubjectId = 2;

        $now = Carbon::now();

        // Paper 1: English Paper (45 marks)
        $englishPaperId = DB::table('papers')->insertGetId([
            'title' => 'English Final Examination',
            'user_id' => $userId,
            'class_id' => $classId,
            'subject_id' => $englishSubjectId,
            'created_by' => 'manual',
            'duration' => 120,
            'total_marks' => 45,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // English Paper Sections
        $englishSection1Id = DB::table('paper_sections')->insertGetId([
            'paper_id' => $englishPaperId,
            'title' => 'Reading Comprehension',
            'instructions' => 'Read the following passages and answer the questions below.',
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $englishSection2Id = DB::table('paper_sections')->insertGetId([
            'paper_id' => $englishPaperId,
            'title' => 'Grammar and Vocabulary',
            'instructions' => 'Answer all questions in this section.',
            'order' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // English Section 1 Groups (Paragraph Questions)
        $englishGroup1Id = DB::table('section_groups')->insertGetId([
            'section_id' => $englishSection1Id,
            'question_type_id' => $paragraphTypeId,
            'title' => 'Passage 1',
            'instructions' => 'Read the passage and answer the questions that follow.',
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Paragraph Question with sub-questions
        $paragraphQuestionId = DB::table('paper_questions')->insertGetId([
            'section_group_id' => $englishGroup1Id,
            'paragraph_text' => "The quick brown fox jumps over the lazy dog. This famous pangram contains every letter of the English alphabet. It's often used for typing practice, handwriting examples, and testing typewriters and computer keyboards. The phrase has been used since at least the late 19th century.",
            'marks' => 15,
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Sub-questions for paragraph
        $subQuestion1Id = DB::table('paper_questions')->insertGetId([
            'section_group_id' => $englishGroup1Id,
            'parent_question_id' => $paragraphQuestionId,
            'question_text' => 'What is a pangram?',
            'marks' => 3,
            'order' => 0,
            'sub_order' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $subQuestion2Id = DB::table('paper_questions')->insertGetId([
            'section_group_id' => $englishGroup1Id,
            'parent_question_id' => $paragraphQuestionId,
            'question_text' => 'Why is this particular sentence famous?',
            'marks' => 4,
            'order' => 0,
            'sub_order' => 2,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $subQuestion3Id = DB::table('paper_questions')->insertGetId([
            'section_group_id' => $englishGroup1Id,
            'parent_question_id' => $paragraphQuestionId,
            'question_text' => 'List three uses of this pangram mentioned in the passage.',
            'marks' => 8,
            'order' => 0,
            'sub_order' => 3,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // English Section 2 Groups (MCQ, Fill in Blanks, Short Answer)
        $englishGroup2Id = DB::table('section_groups')->insertGetId([
            'section_id' => $englishSection2Id,
            'question_type_id' => $mcqTypeId,
            'title' => 'Multiple Choice Questions',
            'instructions' => 'Choose the correct option for each question.',
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // MCQ Questions
        $mcqQuestion1Id = DB::table('paper_questions')->insertGetId([
            'section_group_id' => $englishGroup2Id,
            'question_text' => 'Which of the following is a synonym for "quick"?',
            'marks' => 2,
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('question_options')->insert([
            ['paper_question_id' => $mcqQuestion1Id, 'option_text' => 'Fast', 'is_correct' => true, 'order' => 0, 'created_at' => $now],
            ['paper_question_id' => $mcqQuestion1Id, 'option_text' => 'Slow', 'is_correct' => false, 'order' => 1, 'created_at' => $now],
            ['paper_question_id' => $mcqQuestion1Id, 'option_text' => 'Large', 'is_correct' => false, 'order' => 2, 'created_at' => $now],
            ['paper_question_id' => $mcqQuestion1Id, 'option_text' => 'Small', 'is_correct' => false, 'order' => 3, 'created_at' => $now]
        ]);

        $mcqQuestion2Id = DB::table('paper_questions')->insertGetId([
            'section_group_id' => $englishGroup2Id,
            'question_text' => 'What is the past tense of "jump"?',
            'marks' => 2,
            'order' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('question_options')->insert([
            ['paper_question_id' => $mcqQuestion2Id, 'option_text' => 'Jumped', 'is_correct' => true, 'order' => 0, 'created_at' => $now],
            ['paper_question_id' => $mcqQuestion2Id, 'option_text' => 'Jumps', 'is_correct' => false, 'order' => 1, 'created_at' => $now],
            ['paper_question_id' => $mcqQuestion2Id, 'option_text' => 'Jumping', 'is_correct' => false, 'order' => 2, 'created_at' => $now],
            ['paper_question_id' => $mcqQuestion2Id, 'option_text' => 'Jump', 'is_correct' => false, 'order' => 3, 'created_at' => $now]
        ]);

        // Fill in Blanks Group
        $englishGroup3Id = DB::table('section_groups')->insertGetId([
            'section_id' => $englishSection2Id,
            'question_type_id' => $fillBlanksTypeId,
            'title' => 'Fill in the Blanks',
            'instructions' => 'Fill in the blanks with appropriate words.',
            'order' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('paper_questions')->insert([
            [
                'section_group_id' => $englishGroup3Id,
                'question_text' => 'The cat sat on the _____.',
                'correct_answer' => 'mat',
                'marks' => 2,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'section_group_id' => $englishGroup3Id,
                'question_text' => 'She _____ to school every day.',
                'correct_answer' => 'walks',
                'marks' => 2,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // Short Answer Group
        $englishGroup4Id = DB::table('section_groups')->insertGetId([
            'section_id' => $englishSection2Id,
            'question_type_id' => $shortAnswerTypeId,
            'title' => 'Short Answer Questions',
            'instructions' => 'Answer the following questions briefly.',
            'order' => 2,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('paper_questions')->insert([
            [
                'section_group_id' => $englishGroup4Id,
                'question_text' => 'What is the main purpose of punctuation in writing?',
                'correct_answer' => 'To clarify meaning and separate ideas',
                'marks' => 4,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'section_group_id' => $englishGroup4Id,
                'question_text' => 'Define what a metaphor is and give one example.',
                'correct_answer' => 'A metaphor is a figure of speech that describes an object in a way that isn\'t literally true. Example: "Time is money."',
                'marks' => 6,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // Paper 2: Math Paper (50 marks)
        $mathPaperId = DB::table('papers')->insertGetId([
            'title' => 'Mathematics Final Examination',
            'user_id' => $userId,
            'class_id' => $classId,
            'subject_id' => $mathSubjectId,
            'created_by' => 'manual',
            'duration' => 150,
            'total_marks' => 50,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Math Paper Sections
        $mathSection1Id = DB::table('paper_sections')->insertGetId([
            'paper_id' => $mathPaperId,
            'title' => 'Algebra',
            'instructions' => 'Solve the following algebraic equations and problems.',
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $mathSection2Id = DB::table('paper_sections')->insertGetId([
            'paper_id' => $mathPaperId,
            'title' => 'Geometry',
            'instructions' => 'Answer all geometry questions showing your working.',
            'order' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Math MCQ Group
        $mathGroup1Id = DB::table('section_groups')->insertGetId([
            'section_id' => $mathSection1Id,
            'question_type_id' => $mcqTypeId,
            'title' => 'Multiple Choice',
            'instructions' => 'Choose the correct answer for each question.',
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $mathMcq1Id = DB::table('paper_questions')->insertGetId([
            'section_group_id' => $mathGroup1Id,
            'question_text' => 'What is the solution to 2x + 5 = 15?',
            'marks' => 3,
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('question_options')->insert([
            ['paper_question_id' => $mathMcq1Id, 'option_text' => 'x = 5', 'is_correct' => true, 'order' => 0, 'created_at' => $now],
            ['paper_question_id' => $mathMcq1Id, 'option_text' => 'x = 10', 'is_correct' => false, 'order' => 1, 'created_at' => $now],
            ['paper_question_id' => $mathMcq1Id, 'option_text' => 'x = 7.5', 'is_correct' => false, 'order' => 2, 'created_at' => $now],
            ['paper_question_id' => $mathMcq1Id, 'option_text' => 'x = 20', 'is_correct' => false, 'order' => 3, 'created_at' => $now]
        ]);

        // Math Fill in Blanks
        $mathGroup2Id = DB::table('section_groups')->insertGetId([
            'section_id' => $mathSection1Id,
            'question_type_id' => $fillBlanksTypeId,
            'title' => 'Solve Equations',
            'instructions' => 'Solve for the variable in each equation.',
            'order' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('paper_questions')->insert([
            [
                'section_group_id' => $mathGroup2Id,
                'question_text' => 'If 3y - 7 = 14, then y = _____',
                'correct_answer' => '7',
                'marks' => 4,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'section_group_id' => $mathGroup2Id,
                'question_text' => 'The quadratic formula is x = [-b ± √(b² - 4ac)] / _____',
                'correct_answer' => '2a',
                'marks' => 3,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // Math Long Answer
        $mathGroup3Id = DB::table('section_groups')->insertGetId([
            'section_id' => $mathSection2Id,
            'question_type_id' => $longAnswerTypeId,
            'title' => 'Problem Solving',
            'instructions' => 'Show all your working for the following problems.',
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('paper_questions')->insert([
            [
                'section_group_id' => $mathGroup3Id,
                'question_text' => 'A right triangle has legs of length 3cm and 4cm. Calculate the length of the hypotenuse using the Pythagorean theorem.',
                'correct_answer' => '5cm (using a² + b² = c², 3² + 4² = 9 + 16 = 25, √25 = 5)',
                'marks' => 8,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'section_group_id' => $mathGroup3Id,
                'question_text' => 'Calculate the area of a circle with radius 7cm. Use π = 22/7.',
                'correct_answer' => '154cm² (using A = πr² = 22/7 × 7² = 22/7 × 49 = 22 × 7 = 154)',
                'marks' => 6,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // Paper 3: Physics Paper (40 marks)
        $physicsPaperId = DB::table('papers')->insertGetId([
            'title' => 'Physics Mid-Term Examination',
            'user_id' => $userId,
            'class_id' => $classId,
            'subject_id' => $physicsSubjectId,
            'created_by' => 'manual',
            'duration' => 90,
            'total_marks' => 40,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Physics Paper Sections
        $physicsSectionId = DB::table('paper_sections')->insertGetId([
            'paper_id' => $physicsPaperId,
            'title' => 'Physics Concepts',
            'instructions' => 'Answer all questions in this section.',
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Physics True/False Group
        $physicsGroup1Id = DB::table('section_groups')->insertGetId([
            'section_id' => $physicsSectionId,
            'question_type_id' => $trueFalseTypeId,
            'title' => 'True or False',
            'instructions' => 'Mark each statement as True or False.',
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $physicsTf1Id = DB::table('paper_questions')->insertGetId([
            'section_group_id' => $physicsGroup1Id,
            'question_text' => 'Light travels faster than sound.',
            'marks' => 2,
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('question_options')->insert([
            ['paper_question_id' => $physicsTf1Id, 'option_text' => 'True', 'is_correct' => true, 'order' => 0, 'created_at' => $now],
            ['paper_question_id' => $physicsTf1Id, 'option_text' => 'False', 'is_correct' => false, 'order' => 1, 'created_at' => $now]
        ]);

        $physicsTf2Id = DB::table('paper_questions')->insertGetId([
            'section_group_id' => $physicsGroup1Id,
            'question_text' => 'Water boils at 100°F at sea level.',
            'marks' => 2,
            'order' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('question_options')->insert([
            ['paper_question_id' => $physicsTf2Id, 'option_text' => 'True', 'is_correct' => false, 'order' => 0, 'created_at' => $now],
            ['paper_question_id' => $physicsTf2Id, 'option_text' => 'False', 'is_correct' => true, 'order' => 1, 'created_at' => $now]
        ]);

        // Physics MCQ Group
        $physicsGroup2Id = DB::table('section_groups')->insertGetId([
            'section_id' => $physicsSectionId,
            'question_type_id' => $mcqTypeId,
            'title' => 'Multiple Choice',
            'instructions' => 'Choose the correct answer for each question.',
            'order' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $physicsMcq1Id = DB::table('paper_questions')->insertGetId([
            'section_group_id' => $physicsGroup2Id,
            'question_text' => 'What is the SI unit of force?',
            'marks' => 3,
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('question_options')->insert([
            ['paper_question_id' => $physicsMcq1Id, 'option_text' => 'Newton', 'is_correct' => true, 'order' => 0, 'created_at' => $now],
            ['paper_question_id' => $physicsMcq1Id, 'option_text' => 'Joule', 'is_correct' => false, 'order' => 1, 'created_at' => $now],
            ['paper_question_id' => $physicsMcq1Id, 'option_text' => 'Watt', 'is_correct' => false, 'order' => 2, 'created_at' => $now],
            ['paper_question_id' => $physicsMcq1Id, 'option_text' => 'Pascal', 'is_correct' => false, 'order' => 3, 'created_at' => $now]
        ]);

        // Physics Short Answer
        $physicsGroup3Id = DB::table('section_groups')->insertGetId([
            'section_id' => $physicsSectionId,
            'question_type_id' => $shortAnswerTypeId,
            'title' => 'Short Answer Questions',
            'instructions' => 'Answer the following questions concisely.',
            'order' => 2,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('paper_questions')->insert([
            [
                'section_group_id' => $physicsGroup3Id,
                'question_text' => 'State Newton\'s First Law of Motion.',
                'correct_answer' => 'An object at rest stays at rest and an object in motion stays in motion with the same speed and in the same direction unless acted upon by an unbalanced force.',
                'marks' => 5,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'section_group_id' => $physicsGroup3Id,
                'question_text' => 'Define kinetic energy and give its formula.',
                'correct_answer' => 'Kinetic energy is the energy of motion. Formula: KE = 1/2 mv²',
                'marks' => 4,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // Physics Long Answer with sub-questions
        $physicsGroup4Id = DB::table('section_groups')->insertGetId([
            'section_id' => $physicsSectionId,
            'question_type_id' => $longAnswerTypeId,
            'title' => 'Problem Solving',
            'instructions' => 'Solve the following physics problems showing all calculations.',
            'order' => 3,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $physicsLongQuestionId = DB::table('paper_questions')->insertGetId([
            'section_group_id' => $physicsGroup4Id,
            'question_text' => 'A car accelerates from rest to 60 km/h in 10 seconds. Calculate:',
            'marks' => 10,
            'order' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Sub-questions for physics problem
        DB::table('paper_questions')->insert([
            [
                'section_group_id' => $physicsGroup4Id,
                'parent_question_id' => $physicsLongQuestionId,
                'question_text' => 'The acceleration in m/s²',
                'correct_answer' => '1.67 m/s² (convert 60 km/h to m/s: 60 × 1000/3600 = 16.67 m/s, a = Δv/Δt = 16.67/10 = 1.67 m/s²)',
                'marks' => 4,
                'order' => 0,
                'sub_order' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'section_group_id' => $physicsGroup4Id,
                'parent_question_id' => $physicsLongQuestionId,
                'question_text' => 'The distance traveled during acceleration',
                'correct_answer' => '83.35 meters (using s = ut + 1/2at² = 0 + 1/2 × 1.67 × 100 = 83.5m)',
                'marks' => 6,
                'order' => 0,
                'sub_order' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        $this->command->info('Sample papers created successfully!');
        $this->command->info('English Paper: 45 marks');
        $this->command->info('Math Paper: 50 marks');
        $this->command->info('Physics Paper: 40 marks');
    }
}

