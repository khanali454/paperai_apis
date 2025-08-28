<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudyMaterial;
use Illuminate\Http\Request;

class StudyMaterialController extends Controller
{
    // get all study materials with their files, user, class, and subject
    public function index()
    {
        $user_id = 1;
        $materials = StudyMaterial::with(['files', 'user', 'studentClass', 'subject'])->where("user_id",$user_id)->get();
        return response()->json([
            "status" => true,
            "data" => $materials,
            "message" => "Study materials retrieved successfully."
        ]);
    }
}
