<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

Route::post('/contact', [ContactController::class, 'store']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/contacts', function () {
    return \App\Models\Contact::all();
});

Route::get('/test', function () {
    return response()->json([
        'message' => 'API Working 🚀'
    ]);
});