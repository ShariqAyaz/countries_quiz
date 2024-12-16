<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::middleware('auth:sanctum')->get('/new-question', [QuizController::class,'questionViaApi']);

Route::middleware('auth:sanctum')->post('/post-answer',[QuizController::class, 'postAnswer'])->name('post.answer');

Route::get('/auto-login', function () {
    $user = App\Models\User::where('email', 'test@example.com')->first();
    Auth::login($user);
    return response()->json(['message' => 'User logged in'], 200);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

///Route::post('/post-answer',[QuizController::class, 'postAnswer'])->name('post.answer');