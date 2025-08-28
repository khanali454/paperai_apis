<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Hello World!";
});

// command to run migration & seeding data 
Route::get('/migrate', function () {
    Artisan::call(command: 'migrate:fresh --seed');
    return "Database migrated and seeded!";
});
