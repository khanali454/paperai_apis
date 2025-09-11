<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\PaperTemplateController;
use App\Http\Controllers\Api\StudyMaterialController;
use App\Http\Controllers\Api\SubjectController;
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

Route::post('/user/register', [AuthController::class, 'register']);
Route::post('/user/login', [AuthController::class, 'login']);

Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Paper Template Routes
    Route::prefix('paper-templates')->group(function () {
        // get all templates
        Route::get('/', [PaperTemplateController::class, 'index']);
        // delete template by id
        Route::delete('/{id}', [PaperTemplateController::class, 'destroy']);
    });

    Route::prefix('classes')->group(function () {
        Route::get('/', [ClassController::class, 'index']);
        Route::post('/', [ClassController::class, 'store']);
        Route::get('/{id}', [ClassController::class, 'show']);
        Route::put('/{id}', [ClassController::class, 'update']);
        Route::delete('/{id}', [ClassController::class, 'destroy']);

        // Class-specific Subjects
        Route::prefix('{class}/subjects')->group(function () {
            Route::get('/', [SubjectController::class, 'classSubjects']);       // subjects for a class
            Route::post('/', [SubjectController::class, 'store']);              // add subject to class
            Route::get('/{subject}', [SubjectController::class, 'show']);       // single subject in class
            Route::put('/{subject}', [SubjectController::class, 'update']);     // update subject in class
            Route::delete('/{subject}', [SubjectController::class, 'destroy']); // delete subject
        });

        Route::prefix('study-materials')->group(function () {
            Route::get('/', [StudyMaterialController::class, 'index']);          // list all
            Route::post('/', [StudyMaterialController::class, 'store']);         // upload new
            Route::get('/{id}', [StudyMaterialController::class, 'show']);       // single material
            Route::put('/{id}', [StudyMaterialController::class, 'update']);     // update
            Route::delete('/{id}', [StudyMaterialController::class, 'destroy']); // delete
        });

    });

    // create papers , paper sections , paper questions

    // All Subjects (regardless of class)
    Route::get('/subjects', [SubjectController::class, 'index']);

});
