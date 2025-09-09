<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    // Get all subjects for logged in user
    public function index()
    {
        $subjects = Subject::with('class')
            ->whereHas('class', function ($query) {
                $query->where('organized_by', Auth::id());
            })
            ->get();

        return response()->json([
            'status'  => true,
            'data'    => [
                'subjects' => $subjects,
            ],
            'message' => 'Subjects fetched successfully',
        ]);

    }
    // Get all subjects of a class (only if class belongs to logged in user)
    public function classSubjects($classId)
    {
        $class = StudentClass::with('subjects')->where('organized_by', Auth::id())->find($classId);

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
            'message' => 'Subjects fetched successfully',
        ]);
    }

    // Store a new subject in a class
    public function store(Request $request, $classId)
    {
        $class = StudentClass::where('organized_by', Auth::id())->find($classId);

        if (! $class) {
            return response()->json([
                'status'  => false,
                'message' => 'Class not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => [
                'required',
                'string',
                'max:255'
            ],
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'data'    => [
                    'errors' => $validator->errors(),
                ],
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $subject = Subject::create([
            'name'        => $request->name,
            'description' => $request->description,
            'class_id'    => $class->id,
        ]);

        return response()->json([
            'status'  => true,
            'data'    => [
                'subject' => $subject,
            ],
            'message' => 'Subject created successfully',
        ]);
    }

    // Show a specific subject
    public function show($classId, $id)
    {
        $class = StudentClass::where('organized_by', Auth::id())->find($classId);

        if (! $class) {
            return response()->json([
                'status'  => false,
                'message' => 'Class not found or not authorized',
            ], 404);
        }

        $subject = Subject::where('class_id', $class->id)->find($id);

        if (! $subject) {
            return response()->json([
                'status'  => false,
                'message' => 'Subject not found',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'data'    => [
                'subject' => $subject,
            ],
            'message' => 'Subject retrieved successfully',
        ]);
    }

    // Update a subject
    public function update(Request $request, $classId, $id)
    {
        $class = StudentClass::where('organized_by', Auth::id())->find($classId);

        if (! $class) {
            return response()->json([
                'status'  => false,
                'message' => 'Class not found or not authorized',
            ], 404);
        }

        $subject = Subject::where('class_id', $class->id)->find($id);

        if (! $subject) {
            return response()->json([
                'status'  => false,
                'message' => 'Subject not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => [
                'required',
                'string',
                'max:255'
            ],
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'data'    => [
                    'errors' => $validator->errors(),
                ],
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $subject->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'status'  => true,
            'data'    => [
                'subject' => $subject,
            ],
            'message' => 'Subject updated successfully',
        ]);
    }

    // Delete a subject
    public function destroy($classId, $id)
    {
        $class = StudentClass::where('organized_by', Auth::id())->find($classId);

        if (! $class) {
            return response()->json([
                'status'  => false,
                'message' => 'Class not found or not authorized',
            ], 404);
        }

        $subject = Subject::where('class_id', $class->id)->find($id);

        if (! $subject) {
            return response()->json([
                'status'  => false,
                'message' => 'Subject not found',
            ], 404);
        }

        $subject->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Subject deleted successfully',
        ]);
    }
}
