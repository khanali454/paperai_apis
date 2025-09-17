<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\PaperSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaperSectionController extends Controller
{
    // Store a new section for a paper
    public function store(Request $request, $paperId)
    {
        $paper = Paper::where('user_id', Auth::id())->find($paperId);

        if (!$paper) {
            return response()->json([
                'status' => false,
                'message' => 'Paper not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
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

        $section = $paper->sections()->create($request->all());

        return response()->json([
            'status' => true,
            'data' => [
                'section' => $section->load('sectionGroups.questions'),
            ],
            'message' => 'Section created successfully',
        ], 201);
    }

    // Update a section
    public function update(Request $request, $paperId, $sectionId)
    {
        $paper = Paper::where('user_id', Auth::id())->find($paperId);

        if (!$paper) {
            return response()->json([
                'status' => false,
                'message' => 'Paper not found',
            ], 404);
        }

        $section = $paper->sections()->find($sectionId);

        if (!$section) {
            return response()->json([
                'status' => false,
                'message' => 'Section not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'instructions' => 'nullable|string',
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

        $section->update($request->all());

        return response()->json([
            'status' => true,
            'data' => [
                'section' => $section->load('sectionGroups.questions'),
            ],
            'message' => 'Section updated successfully',
        ]);
    }

    // Delete a section
    public function destroy($paperId, $sectionId)
    {
        $paper = Paper::where('user_id', Auth::id())->find($paperId);

        if (!$paper) {
            return response()->json([
                'status' => false,
                'message' => 'Paper not found',
            ], 404);
        }

        $section = $paper->sections()->find($sectionId);

        if (!$section) {
            return response()->json([
                'status' => false,
                'message' => 'Section not found',
            ], 404);
        }

        $section->delete();

        // Reorder remaining sections
        $paper->sections()
            ->orderBy('order')
            ->get()
            ->each(function ($section, $index) {
                $section->update(['order' => $index]);
            });

        return response()->json([
            'status' => true,
            'message' => 'Section deleted successfully',
        ]);
    }
}