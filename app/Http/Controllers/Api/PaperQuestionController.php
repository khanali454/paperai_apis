<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaperQuestion;
use App\Models\QuestionType;
use App\Models\SectionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaperQuestionController extends Controller
{
    // Store a new question for a section group
    public function store(Request $request, $groupId)
    {
        $group = SectionGroup::with('questionType')
            ->whereHas('section.paper', function ($query) {
                $query->where('user_id', Auth::id());
            })->find($groupId);

        if (! $group) {
            return response()->json([
                'status'  => false,
                'message' => 'Section group not found. Please check the group ID.',
            ], 404);
        }

        $questionType = $group->questionType;

        // Base validation rules
        $validationRules = [
            'question_text'  => 'nullable|string',
            'paragraph_text' => 'nullable|string',
            'correct_answer' => 'nullable|string',
            'marks'          => 'required|integer|min:0',
            'order'          => 'required|integer|min:0',
            'sub_questions'  => 'nullable|array',
            'options'        => 'nullable|array',
        ];

        // Add validation for sub-questions if provided
        if ($request->has('sub_questions')) {
            $validationRules['sub_questions.*.question_text']  = 'required|string';
            $validationRules['sub_questions.*.correct_answer'] = 'nullable|string';
            $validationRules['sub_questions.*.marks']          = 'required|integer|min:0';
            $validationRules['sub_questions.*.sub_order']      = 'required|integer|min:0';
        }

        // Add validation for options if provided
        if ($request->has('options')) {
            $validationRules['options.*.option_text'] = 'required|string';
            $validationRules['options.*.is_correct']  = 'required|boolean';
            $validationRules['options.*.order']       = 'required|integer|min:0';
        }

        // Add question type specific validations
        switch ($questionType->slug) {
            case 'mcq':
            case 'true-false':
                $validationRules['question_text'] = 'required|string';
                $validationRules['options']       = 'required|array|min:2';
                $validationRules['sub_questions'] = 'prohibited';
                break;

            case 'fill-in-blanks':
                $validationRules['question_text']  = 'required|string';
                $validationRules['correct_answer'] = 'required|string';
                $validationRules['options']        = 'prohibited';
                $validationRules['sub_questions']  = 'prohibited';
                break;

            case 'short-answer':
            case 'long-answer':
                $validationRules['question_text'] = 'required|string';
                $validationRules['options']       = 'prohibited';
                // For questions with sub-questions, main question marks should be 0
                if ($request->has('sub_questions')) {
                    $validationRules['marks'] = 'nullable|integer|min:0';
                }
                break;

            case 'paragraph':
                $validationRules['paragraph_text'] = 'required|string';
                $validationRules['sub_questions']  = 'required|array|min:1';
                $validationRules['options']        = 'prohibited';
                $validationRules['marks']          = 'nullable|integer|min:0';
                break;

            case 'conditional':
                $validationRules['question_text'] = 'required|string';
                $validationRules['sub_questions'] = 'required|array|min:2';
                $validationRules['options']       = 'prohibited';
                $validationRules['marks']         = 'nullable|integer|min:0';
                break;
        }

        $validator = Validator::make($request->all(), $validationRules, [
            'question_text.required'                 => 'Question text is required for this question type.',
            'paragraph_text.required'                => 'Paragraph text is required for paragraph questions.',
            'options.required'                       => 'Options are required for this question type.',
            'options.min'                            => 'At least 2 options are required for multiple choice questions.',
            'correct_answer.required'                => 'Correct answer is required for fill in the blanks questions.',
            'sub_questions.required'                 => 'Sub questions are required for paragraph and conditional questions.',
            'sub_questions.min'                      => 'At least 1 sub question is required.',
            'options.prohibited'                     => 'Options are not allowed for this question type.',
            'sub_questions.prohibited'               => 'Sub questions are not allowed for this question type.',
            'sub_questions.*.question_text.required' => 'Each sub question must have text.',
            'sub_questions.*.marks.required'         => 'Each sub question must have marks.',
            'sub_questions.*.sub_order.required'     => 'Each sub question must have an order.',
            'options.*.option_text.required'         => 'Each option must have text.',
            'options.*.is_correct.required'          => 'Each option must specify if it is correct or not.',
            'options.*.order.required'               => 'Each option must have an order.',
        ]);

        // custom rule for option -  validation
        $validator->after(function ($validator) use ($request) {
            if ($request->has('options')) {
                $correctCount = collect($request->input('options'))
                    ->where('is_correct', true)
                    ->count();

                if ($correctCount !== 1) {
                    $validator->errors()->add('options', 'Exactly one option must be marked as correct.');
                }
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'data'    => [
                    "errors" => $validator->errors(),
                ],
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Prepare question data
        $questionData = $request->only(['question_text', 'paragraph_text', 'correct_answer', 'marks', 'order']);

        // For questions with sub-questions, set main question marks to 0
        if ($request->has('sub_questions') && in_array($questionType->slug, ['short-answer', 'long-answer', 'paragraph', 'conditional'])) {
            $questionData['marks'] = 0;
        }

        $question = $group->questions()->create($questionData);

        // Create options if provided
        if ($request->has('options') && $questionType->has_options) {
            foreach ($request->options as $optionData) {
                $question->options()->create($optionData);
            }
        }

        // Create sub-questions if provided
        $totalSubQuestionMarks = 0;
        if ($request->has('sub_questions') && $questionType->can_have_sub_questions) {
            foreach ($request->sub_questions as $subQuestionData) {
                $subQuestion = $question->subQuestions()->create([
                    'section_group_id' => $groupId,
                    'question_text'    => $subQuestionData['question_text'],
                    'correct_answer'   => $subQuestionData['correct_answer'] ?? null,
                    'marks'            => $subQuestionData['marks'],
                    'sub_order'        => $subQuestionData['sub_order'],
                ]);

                $totalSubQuestionMarks += $subQuestion->marks;
            }
        }

        // Update paper total marks
        $paper = $group->section->paper;
        $paper->total_marks += ($question->marks + $totalSubQuestionMarks);
        $paper->save();

        return response()->json([
            'status'  => true,
            'data'    => [
                'question' => $question->load(['options', 'subQuestions']),
            ],
            'message' => 'Question created successfully',
        ], 201);
    }

    // Update a question
    public function update(Request $request, $groupId, $questionId)
    {
        $group = SectionGroup::with('questionType')
            ->whereHas('section.paper', function ($query) {
                $query->where('user_id', Auth::id());
            })->find($groupId);

        if (! $group) {
            return response()->json([
                'status'  => false,
                'message' => 'Section group not found. Please check the group ID.',
            ], 404);
        }

        $question = $group->questions()->with('subQuestions')->find($questionId);

        if (! $question) {
            return response()->json([
                'status'  => false,
                'message' => 'Question not found. Please check the question ID.',
            ], 404);
        }

        $questionType = $group->questionType;

        // Base validation rules
        $validationRules = [
            'question_text'  => 'nullable|string',
            'paragraph_text' => 'nullable|string',
            'correct_answer' => 'nullable|string',
            'marks'          => 'sometimes|integer|min:0',
            'order'          => 'sometimes|integer|min:0',
        ];

        // Add question type specific validations
        switch ($questionType->slug) {
            case 'mcq':
            case 'true-false':
                $validationRules['question_text'] = 'sometimes|required|string';
                break;

            case 'fill-in-blanks':
                $validationRules['question_text']  = 'sometimes|required|string';
                $validationRules['correct_answer'] = 'sometimes|required|string';
                break;

            case 'short-answer':
            case 'long-answer':
                $validationRules['question_text'] = 'sometimes|required|string';
                // If it's a parent question with sub-questions, marks should be 0
                if ($question->subQuestions()->count() > 0) {
                    $validationRules['marks'] = 'nullable|integer|min:0';
                }
                break;

            case 'paragraph':
                if (! $question->parent_question_id) {
                    $validationRules['paragraph_text'] = 'sometimes|required|string';
                    $validationRules['marks']          = 'nullable|integer|min:0';
                }
                break;

            case 'conditional':
                if (! $question->parent_question_id) {
                    $validationRules['question_text'] = 'sometimes|required|string';
                    $validationRules['marks']         = 'nullable|integer|min:0';
                }
                break;
        }

        $validator = Validator::make($request->all(), $validationRules, [
            'question_text.required'  => 'Question text is required for this question type.',
            'paragraph_text.required' => 'Paragraph text is required for paragraph questions.',
            'correct_answer.required' => 'Correct answer is required for fill in the blanks questions.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'data'    => [
                    "errors" => $validator->errors(),
                ],
                'message' => 'Validation failed. Please check your input.',
            ], 422);
        }

        $oldMarks = $question->marks;
        $question->update($request->only(['question_text', 'paragraph_text', 'correct_answer', 'marks', 'order']));

        // Update paper total marks if marks changed
        if ($oldMarks != $question->marks) {
            $paper = $group->section->paper;
            $paper->total_marks += ($question->marks - $oldMarks);
            $paper->save();
        }

        return response()->json([
            'status'  => true,
            'data'    => [
                'question' => $question->load(['options', 'subQuestions']),
            ],
            'message' => 'Question updated successfully',
        ]);
    }

    // Delete a question
    public function destroy($groupId, $questionId)
    {
        $group = SectionGroup::whereHas('section.paper', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($groupId);

        if (! $group) {
            return response()->json([
                'status'  => false,
                'message' => 'Section group not found. Please check the group ID.',
            ], 404);
        }

        $question = $group->questions()->with('subQuestions')->find($questionId);

        if (! $question) {
            return response()->json([
                'status'  => false,
                'message' => 'Question not found. Please check the question ID.',
            ], 404);
        }

        // Update paper total marks
        $paper      = $group->section->paper;
        $totalMarks = $question->marks;

        // Add marks from sub-questions if this is a parent question
        if ($question->subQuestions->count() > 0) {
            $totalMarks += $question->subQuestions->sum('marks');
        }

        $paper->total_marks -= $totalMarks;
        $paper->save();

        // Delete all sub-questions first
        if ($question->subQuestions->count() > 0) {
            $question->subQuestions()->delete();
        }

        // Delete all options
        $question->options()->delete();

        $question->delete();

        // Reorder remaining questions
        if ($question->parent_question_id) {
            // This is a sub-question, reorder within parent
            PaperQuestion::where('parent_question_id', $question->parent_question_id)
                ->orderBy('sub_order')
                ->get()
                ->each(function ($subQuestion, $index) {
                    $subQuestion->update(['sub_order' => $index]);
                });
        } else {
            // This is a main question, reorder within section group
            $group->questions()
                ->whereNull('parent_question_id')
                ->orderBy('order')
                ->get()
                ->each(function ($question, $index) {
                    $question->update(['order' => $index]);
                });
        }

        return response()->json([
            'status'  => true,
            'message' => 'Question deleted successfully',
        ]);
    }

    // Add options to a question
    public function addOptions(Request $request, $groupId, $questionId)
    {
        $group = SectionGroup::with('questionType')
            ->whereHas('section.paper', function ($query) {
                $query->where('user_id', Auth::id());
            })->find($groupId);

        if (! $group) {
            return response()->json([
                'status'  => false,
                'message' => 'Section group not found. Please check the group ID.',
            ], 404);
        }

        $question = $group->questions()->find($questionId);

        if (! $question) {
            return response()->json([
                'status'  => false,
                'message' => 'Question not found. Please check the question ID.',
            ], 404);
        }

        // Check if question type supports options
        if (! $group->questionType->has_options) {
            return response()->json([
                'status'  => false,
                'message' => 'This question type does not support options.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'options'               => 'required|array|min:2',
            'options.*.option_text' => 'required|string',
            'options.*.is_correct'  => 'required|boolean',
            'options.*.order'       => 'required|integer|min:0',
        ], [
            'options.required'               => 'Options are required.',
            'options.min'                    => 'At least 2 options are required.',
            'options.*.option_text.required' => 'Each option must have text.',
            'options.*.is_correct.required'  => 'Each option must specify if it is correct or not.',
            'options.*.order.required'       => 'Each option must have an order.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'data'    => [
                    "errors" => $validator->errors(),
                ],
                'message' => 'Validation failed. Please check your input.',
            ], 422);
        }

        // Delete existing options
        $question->options()->delete();

        // Create new options
        foreach ($request->options as $optionData) {
            $question->options()->create($optionData);
        }

        return response()->json([
            'status'  => true,
            'data'    => [
                'question' => $question->load('options'),
            ],
            'message' => 'Options updated successfully',
        ]);
    }

    // Add sub-questions to a question
    public function addSubQuestions(Request $request, $groupId, $questionId)
    {
        $group = SectionGroup::with('questionType')
            ->whereHas('section.paper', function ($query) {
                $query->where('user_id', Auth::id());
            })->find($groupId);

        if (! $group) {
            return response()->json([
                'status'  => false,
                'message' => 'Section group not found. Please check the group ID.',
            ], 404);
        }

        $question = $group->questions()->find($questionId);

        if (! $question) {
            return response()->json([
                'status'  => false,
                'message' => 'Question not found. Please check the question ID.',
            ], 404);
        }

        // Check if question type supports sub-questions
        if (! $group->questionType->can_have_sub_questions) {
            return response()->json([
                'status'  => false,
                'message' => 'This question type does not support sub-questions.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'sub_questions'                  => 'required|array|min:1',
            'sub_questions.*.question_text'  => 'required|string',
            'sub_questions.*.correct_answer' => 'nullable|string',
            'sub_questions.*.marks'          => 'required|integer|min:0',
            'sub_questions.*.sub_order'      => 'required|integer|min:0',
        ], [
            'sub_questions.required'                 => 'Sub questions are required.',
            'sub_questions.min'                      => 'At least 1 sub question is required.',
            'sub_questions.*.question_text.required' => 'Each sub question must have text.',
            'sub_questions.*.marks.required'         => 'Each sub question must have marks.',
            'sub_questions.*.sub_order.required'     => 'Each sub question must have an order.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'data'    => [
                    "errors" => $validator->errors(),
                ],
                'message' => 'Validation failed. Please check your input.',
            ], 422);
        }

        // Delete existing sub-questions
        $oldSubQuestionsMarks = $question->subQuestions->sum('marks');
        $question->subQuestions()->delete();

        // Create new sub-questions
        $newSubQuestionsMarks = 0;
        foreach ($request->sub_questions as $subQuestionData) {
            $subQuestion = $question->subQuestions()->create([
                'section_group_id' => $groupId,
                'question_text'    => $subQuestionData['question_text'],
                'correct_answer'   => $subQuestionData['correct_answer'] ?? null,
                'marks'            => $subQuestionData['marks'],
                'sub_order'        => $subQuestionData['sub_order'],
            ]);

            $newSubQuestionsMarks += $subQuestion->marks;
        }

        // Update paper total marks
        $paper = $group->section->paper;
        $paper->total_marks += ($newSubQuestionsMarks - $oldSubQuestionsMarks);
        $paper->save();

        return response()->json([
            'status'  => true,
            'data'    => [
                'question' => $question->load('subQuestions'),
            ],
            'message' => 'Sub-questions updated successfully',
        ]);
    }
}
