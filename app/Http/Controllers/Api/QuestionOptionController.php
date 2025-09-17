<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaperQuestion;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuestionOptionController extends Controller
{
    // Store a new option for a question
    public function store(Request $request, $questionId)
    {
        $question = PaperQuestion::whereHas('sectionGroup.section.paper', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($questionId);

        if (!$question) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'option_text' => 'required|string',
            'is_correct' => 'required|boolean',
            'order' => 'required|integer|min:0',
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

        $option = $question->options()->create($request->all());

        return response()->json([
            'status' => true,
            'data' => [
                'option' => $option,
            ],
            'message' => 'Option created successfully',
        ], 201);
    }

    // Update an option
    public function update(Request $request, $questionId, $optionId)
    {
        $question = PaperQuestion::whereHas('sectionGroup.section.paper', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($questionId);

        if (!$question) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        }

        $option = $question->options()->find($optionId);

        if (!$option) {
            return response()->json([
                'status' => false,
                'message' => 'Option not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'option_text' => 'sometimes|required|string',
            'is_correct' => 'sometimes|required|boolean',
            'order' => 'sometimes|required|integer|min:0',
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

        $option->update($request->all());

        return response()->json([
            'status' => true,
            'data' => [
                'option' => $option,
            ],
            'message' => 'Option updated successfully',
        ]);
    }

    // Delete an option
    public function destroy($questionId, $optionId)
    {
        $question = PaperQuestion::whereHas('sectionGroup.section.paper', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($questionId);

        if (!$question) {
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        }

        $option = $question->options()->find($optionId);

        if (!$option) {
            return response()->json([
                'status' => false,
                'message' => 'Option not found',
            ], 404);
        }

        $option->delete();

        // Reorder remaining options
        $question->options()
            ->orderBy('order')
            ->get()
            ->each(function ($option, $index) {
                $option->update(['order' => $index]);
            });

        return response()->json([
            'status' => true,
            'message' => 'Option deleted successfully',
        ]);
    }
}