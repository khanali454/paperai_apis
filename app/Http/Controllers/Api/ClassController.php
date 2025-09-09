<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    // Get all classes for logged in user
    public function index()
    {
        $classes = StudentClass::where('organized_by', Auth::id())->get();

        return response()->json([
            'status'  => true,
            'data'    => [
                'classes' => $classes,
            ],
            'message' => 'Classes fetched successfully',
        ]);
    }

    // Store a new class
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
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

        $class = StudentClass::create([
            'name'         => $request->name,
            'description'  => $request->description,
            'organized_by' => Auth::id(),
        ]);

        return response()->json([
            'status'  => true,
            'data'    => [
                'class' => $class,
            ],
            'message' => 'Class created successfully',
        ]);
    }

    // Show a specific class
    public function show($id)
    {
        $class = StudentClass::where('organized_by', Auth::id())->find($id);

        if (! $class) {
            return response()->json([
                'status'  => false,
                'message' => 'Class not found',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'data'    => [
                'class' => $class,
            ],
            'message' => 'Class retrieved successfully',
        ]);
    }

    // Update a class
    public function update(Request $request, $id)
    {
        $class = StudentClass::where('organized_by', Auth::id())->find($id);

        if (! $class) {
            return response()->json([
                'status'  => false,
                'message' => 'Class not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
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

        $class->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'status'  => true,
            'data'    => [
                'class' => $class,
            ],
            'message' => 'Class updated successfully',
        ]);
    }

    // Delete a class
    public function destroy($id)
    {
        $class = StudentClass::where('organized_by', Auth::id())->find($id);

        if (! $class) {
            return response()->json([
                'status'  => false,
                'message' => 'Class not found',
            ], 404);
        }

        $class->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Class deleted successfully',
        ]);
    }
}
