<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaperSection;
use App\Models\SectionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SectionGroupController extends Controller
{
    // Store a new section group for a section
    public function store(Request $request, $sectionId)
    {
        $section = PaperSection::whereHas('paper', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($sectionId);

        if (!$section) {
            return response()->json([
                'status' => false,
                'message' => 'Section not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'question_type_id' => 'required|exists:question_types,id',
            'instructions' => 'nullable|string',
            'logic' => 'nullable|string',
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

        $group = $section->sectionGroups()->create($request->all());

        return response()->json([
            'status' => true,
            'data' => [
                'group' => $group->load(['questions.options', 'questions.subQuestions']),
            ],
            'message' => 'Section group created successfully',
        ], 201);
    }

    // Update a section group
    public function update(Request $request, $sectionId, $groupId)
    {
        $section = PaperSection::whereHas('paper', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($sectionId);

        if (!$section) {
            return response()->json([
                'status' => false,
                'message' => 'Section not found',
            ], 404);
        }

        $group = $section->sectionGroups()->find($groupId);

        if (!$group) {
            return response()->json([
                'status' => false,
                'message' => 'Section group not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'question_type_id' => 'sometimes|required|exists:question_types,id',
            'instructions' => 'nullable|string',
            'logic' => 'nullable|string',
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

        $group->update($request->all());

        return response()->json([
            'status' => true,
            'data' => [
                'group' => $group->load(['questions.options', 'questions.subQuestions']),
            ],
            'message' => 'Section group updated successfully',
        ]);
    }

    // Delete a section group
    public function destroy($sectionId, $groupId)
    {
        $section = PaperSection::whereHas('paper', function ($query) {
            $query->where('user_id', Auth::id());
        })->find($sectionId);

        if (!$section) {
            return response()->json([
                'status' => false,
                'message' => 'Section not found',
            ], 404);
        }

        $group = $section->sectionGroups()->find($groupId);

        if (!$group) {
            return response()->json([
                'status' => false,
                'message' => 'Section group not found',
            ], 404);
        }

        $group->delete();

        // Reorder remaining groups
        $section->sectionGroups()
            ->orderBy('order')
            ->get()
            ->each(function ($group, $index) {
                $group->update(['order' => $index]);
            });

        return response()->json([
            'status' => true,
            'message' => 'Section group deleted successfully',
        ]);
    }
}