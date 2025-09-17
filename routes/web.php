<?php

use App\Models\Paper;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Hello World! sir";
});

Route::get('/papers', function () {
    return Paper::with(['sections.sectionGroups.questions.options', 'sections.sectionGroups.questions.subQuestions'])->get();
});
// command to run migration & seeding data
Route::get('/migrate', function () {
    Artisan::call(command: 'migrate:fresh --seed');
    return "Database migrated and seeded!";
});
Route::get('/storage-link', function () {
    Artisan::call(command: 'storage:link');
    return "Link Created Successfully";
});
