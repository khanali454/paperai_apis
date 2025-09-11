<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaterialType;
use Illuminate\Http\Request;

class MaterialTypeController extends Controller
{
    public function index(){
        $material_types = MaterialType::all();
        return response()->json([
            'status'  => true,
            'data'    => [
                'material_types' => $material_types,
            ],
            'message' => 'Material types fetched successfully',
        ]);
    }
}
