<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::middleware('web')->get('/new-question', [QuizController::class,'questionViaApi']);

Route::middleware('web')->post('/post-answer',[QuizController::class, 'postAnswer'])->name('post.answer');

Route::middleware('web')->get('/auto-login', function () {
    $user = App\Models\User::where('email', 'test@example.com')->first();
    Auth::login($user);
    return response()->json(['message' => 'User logged in'], 200);
});


Route::post('/logout', [AuthController::class, 'logout'])->middleware('web');

///Route::post('/post-answer',[QuizController::class, 'postAnswer'])->name('post.answer');