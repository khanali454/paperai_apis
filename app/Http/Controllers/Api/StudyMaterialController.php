<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudyMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudyMaterialController extends Controller
{
    /**
     * Get all study materials for logged in user
     */
    public function index()
    {
        $materials = StudyMaterial::with(['user', 'studentClass', 'subject', 'type'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'status'  => true,
            'data'    => [
                'materials' => $materials,
            ],
            'message' => 'Study materials fetched successfully',
        ]);
    }

    /**
     * Store a new study material
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'            => 'required|string|max:100',
            'description'      => 'nullable|string|max:200',
            'material_type_id' => ['required', Rule::exists('material_types', 'id')],
            'class_id'         => ['required', Rule::exists('student_classes', 'id')],
            'subject_id'       => ['required', Rule::exists('subjects', 'id')],
            'is_public'        => 'boolean',
            'file'             => 'required|file|mimes:pdf,ppt,pptx,doc,docx,xls,xlsx,txt,png,jpeg,jpg|max:46080',
            'thumbnail'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'data'    => [
                    "errors" => $validator->errors(),
                ],
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Save file & thumbnail
        $filePath  = $request->file('file')->store('study_materials/files', 'public');
        $thumbPath = $request->hasFile('thumbnail')
            ? $request->file('thumbnail')->store('study_materials/thumbnails', 'public')
            : null;

        $material = StudyMaterial::create([
            'title'            => $request->title,
            'description'      => $request->description,
            'material_type_id' => $request->material_type_id,
            'user_id'          => Auth::id(),
            'class_id'         => $request->class_id,
            'subject_id'       => $request->subject_id,
            'is_public'        => $request->is_public ?? false,
            'thumbnail'        => $thumbPath,
            'file_path'        => $filePath,
            'file_type'        => $request->file('file')->getClientOriginalExtension(),
            'file_name'        => $request->file('file')->getClientOriginalName(),
        ]);

        return response()->json([
            'status'  => true,
            'data'    => [
                'material' => $material,
            ],
            'message' => 'Study material created successfully',
        ], 201);
    }

    /**
     * Show single material
     */
    public function show($id)
    {
        $material = StudyMaterial::with(['user', 'studentClass', 'subject', 'type'])
            ->where('user_id', Auth::id())
            ->find($id);

        if (! $material) {
            return response()->json([
                'status'  => false,
                'message' => 'Study material not found',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'data'    => [
                'material' => $material,
            ],
            'message' => 'Study material retrieved successfully',
        ]);
    }

    /**
     * Update study material
     */
    public function update(Request $request, $id)
    {
        $material = StudyMaterial::where('user_id', Auth::id())->find($id);

        if (! $material) {
            return response()->json([
                'status'  => false,
                'message' => 'Study material not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'            => 'sometimes|string|max:100',
            'description'      => 'nullable|string|max:200',
            'material_type_id' => ['sometimes', Rule::exists('material_types', 'id')],
            'class_id'         => ['sometimes', Rule::exists('student_classes', 'id')],
            'subject_id'       => ['sometimes', Rule::exists('subjects', 'id')],
            'is_public'        => 'boolean',
            'file'             => 'sometimes|file|mimes:pdf,ppt,pptx,doc,docx,xls,xlsx,txt,png,jpeg,jpg|max:46080',
            'thumbnail'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'data'    => [
                    "errors" => $validator->errors(),
                ],
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Replace file if uploaded
        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $material->file_path = $request->file('file')->store('study_materials/files', 'public');
            $material->file_type = $request->file('file')->getClientOriginalExtension();
            $material->file_name = $request->file('file')->getClientOriginalName();
        }

        // Replace thumbnail if uploaded
        if ($request->hasFile('thumbnail')) {
            if ($material->thumbnail) {
                Storage::disk('public')->delete($material->thumbnail);
            }
            $material->thumbnail = $request->file('thumbnail')->store('study_materials/thumbnails', 'public');
        }

        $material->update($request->only([
            'title', 'description', 'material_type_id', 'class_id', 'subject_id', 'is_public',
        ]));

        return response()->json([
            'status'  => true,
            'data'    => [
                'material' => $material,
            ],
            'message' => 'Study material updated successfully',
        ]);
    }

    /**
     * Delete study material
     */
    public function destroy($id)
    {
        $material = StudyMaterial::where('user_id', Auth::id())->find($id);

        if (! $material) {
            return response()->json([
                'status'  => false,
                'message' => 'Study material not found',
            ], 404);
        }

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        if ($material->thumbnail) {
            Storage::disk('public')->delete($material->thumbnail);
        }

        $material->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Study material deleted successfully',
        ]);
    }
}
