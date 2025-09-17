<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaperQuestion;
use App\Models\SectionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaperQuestionController extends Controller
{
    // Store a new question for a section group
    public function store(Request $request, $groupId)
    {
        $group = SectionGroup::whereHas('section.paper', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($groupId);

        if (!$group) {
            return response()->json([
                'status' => false,
                'message' => 'Section group not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'parent_question_id' => 'nullable|exists:paper_questions,id',
            'question_text' => 'nullable|string',
            'paragraph_text' => 'nullable|string',
            'correct_answer' => 'nullable|string',
            'marks' => 'required|integer|min:0',
            'order' => 'required|integer|min:0',
            'sub_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => [
                    "errors" => $validator->errors(),
                ],
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $question = $group->questions()->create($request->all());

        // Update paper total marks
        $paper = $group->section->paper;
        $paper->total_marks += $question->marks;
        $paper->save();

        return response()->json([
            'status' => true,
            'data' => [
                'question' => $question->load(['options', 'subQuestions.options']),
            ],
            'message' => 'Question created successfully',
        ], 201);
    }

    // Update a question
    public function update(Request $request, $groupId, $questionId)
    {
        $group = SectionGroup::whereHas('section.paper', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($groupId);

        if (!$group) {
            return response()->json([
                'status' => false,
                'message' => 'Section group not found',
            ], 404);
        }

        $question = $group->questions()->find($questionId);

        if (!$question) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'parent_question_id' => 'nullable|exists:paper_questions,id',
            'question_text' => 'nullable|string',
            'paragraph_text' => 'nullable|string',
            'correct_answer' => 'nullable|string',
            'marks' => 'sometimes|required|integer|min:0',
            'order' => 'sometimes|required|integer|min:0',
            'sub_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => [
                    "errors" => $validator->errors(),
                ],
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $oldMarks = $question->marks;
        $question->update($request->all());
        
        // Update paper total marks if marks changed
        if ($oldMarks != $question->marks) {
            $paper = $group->section->paper;
            $paper->total_marks += ($question->marks - $oldMarks);
            $paper->save();
        }

        return response()->json([
            'status' => true,
            'data' => [
                'question' => $question->load(['options', 'subQuestions.options']),
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

        if (!$group) {
            return response()->json([
                'status' => false,
                'message' => 'Section group not found',
            ], 404);
        }

        $question = $group->questions()->find($questionId);

        if (!$question) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        }

        // Update paper total marks
        $paper = $group->section->paper;
        $paper->total_marks -= $question->marks;
        $paper->save();

        $question->delete();

        // Reorder remaining questions
        $group->questions()
            ->whereNull('parent_question_id')
            ->orderBy('order')
            ->get()
            ->each(function ($question, $index) {
                $question->update(['order' => $index]);
            });

        return response()->json([
            'status' => true,
            'message' => 'Question deleted successfully',
        ]);
    }
}