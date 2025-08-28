<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaperTemplate;
use Illuminate\Http\Request;

class PaperTemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = PaperTemplate::with(['sections','createdBy'])->get();
        return response()->json([
            'status'  =>true,
            'data'    => $templates,
            'message' => 'Paper templates retrieved successfully.',
        ], 200);
    }
}
