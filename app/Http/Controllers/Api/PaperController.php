<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaperController extends Controller
{
    // Get all papers for logged in user
    public function index()
    {
        $papers = Paper::with(['sections.sectionGroups.questions.options', 'sections.sectionGroups.questions.subQuestions'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'papers' => $papers,
            ],
            'message' => 'Papers fetched successfully',
        ]);
    }

    // Store a new paper
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'class_id' => 'required|exists:student_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'created_by' => 'required|in:manual,ai_created,ai_composed',
            'uploaded_paper_file' => 'nullable|string',
            'data_source' => 'nullable|in:public,personal',
            'duration' => 'required|integer|min:1',
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

        $paper = Paper::create([
            'title' => $request->title,
            'user_id' => Auth::id(),
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'created_by' => $request->created_by,
            'uploaded_paper_file' => $request->uploaded_paper_file,
            'data_source' => $request->data_source,
            'duration' => $request->duration,
            'total_marks' => 0,
        ]);

        return response()->json([
            'status' => true,
            'data' => [
                'paper' => $paper->load(['sections.sectionGroups.questions.options', 'sections.sectionGroups.questions.subQuestions']),
            ],
            'message' => 'Paper created successfully',
        ], 201);
    }

    // Show a specific paper
    public function show($id)
    {
        $paper = Paper::with(['sections.sectionGroups.questionType', 'sections.sectionGroups.questions.options', 'sections.sectionGroups.questions.subQuestions.options'])
            ->where('user_id', Auth::id())
            ->find($id);

        if (!$paper) {
            return response()->json([
                'status' => false,
                'message' => 'Paper not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'paper' => $paper,
            ],
            'message' => 'Paper retrieved successfully',
        ]);
    }

    // Update a paper
    public function update(Request $request, $id)
    {
        $paper = Paper::where('user_id', Auth::id())->find($id);

        if (!$paper) {
            return response()->json([
                'status' => false,
                'message' => 'Paper not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'class_id' => 'sometimes|required|exists:student_classes,id',
            'subject_id' => 'sometimes|required|exists:subjects,id',
            'created_by' => 'sometimes|required|in:manual,ai_created,ai_composed',
            'uploaded_paper_file' => 'nullable|string',
            'data_source' => 'nullable|in:public,personal',
            'duration' => 'sometimes|required|integer|min:1',
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

        $paper->update($request->all());

        return response()->json([
            'status' => true,
            'data' => [
                'paper' => $paper->load(['sections.sectionGroups.questions.options', 'sections.sectionGroups.questions.subQuestions']),
            ],
            'message' => 'Paper updated successfully',
        ]);
    }

    // Delete a paper
    public function destroy($id)
    {
        $paper = Paper::where('user_id', Auth::id())->find($id);

        if (!$paper) {
            return response()->json([
                'status' => false,
                'message' => 'Paper not found',
            ], 404);
        }

        $paper->delete();

        return response()->json([
            'status' => true,
            'message' => 'Paper deleted successfully',
        ]);
    }
}