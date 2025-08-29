<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaperTemplate;
use Illuminate\Http\Request;

class PaperTemplateController extends Controller
{
    // get all templates of a logged in user
    public function index(Request $request)
    {
        $templates = PaperTemplate::with(['sections', 'createdBy'])->where('created_by', $request->user()->id)->get();
        return response()->json([
            'status'  => true,
            'data'    => $templates,
            'message' => 'Paper templates retrieved successfully.',
        ], 200);
    }

    // delete template by id
    public function destroy(Request $request, $id)
    {
        $template = PaperTemplate::where('id', $id)->where('created_by', $request->user()->id)->first();
        if (! $template) {
            return response()->json(['status' => false, 'message' => 'Template not found'], 404);
        }
        $template->delete();
        return response()->json(['status' => true, 'message' => 'Template deleted successfully.'], 200);
    }
}
