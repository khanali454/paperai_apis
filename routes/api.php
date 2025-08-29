<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaperTemplateController;
use App\Http\Controllers\Api\StudyMaterialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Define API routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->name('user');

// To check the health of the API
Route::get('/', function () {
    return response()->json(['status' => 'OK']);
})->name('health');

// Study Material Routes
Route::prefix('study-materials')->group(function () {
    Route::get('/', [StudyMaterialController::class, 'index']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Paper Template Routes
    Route::prefix('paper-templates')->group(function () {
        // get all templates
        Route::get('/', [PaperTemplateController::class, 'index']);
        // delete template by id
        Route::delete('/{id}', [PaperTemplateController::class, 'destroy']);
    });

});
