<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testing-api', function() {
    return response()->json([
        'message' => 'Hello World'
    ]);
});