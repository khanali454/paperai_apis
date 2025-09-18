<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuestionType;
use Illuminate\Http\Request;

class QuestionTypeController extends Controller
{
    public function index()
    {
        $questionTypes  = QuestionType::all();
         return response()->json([
            'status' => true,
            'data' => [
                'question_types' => $questionTypes,
            ],
            'message' => 'Question types fetched successfully',
        ]);
    }
}
