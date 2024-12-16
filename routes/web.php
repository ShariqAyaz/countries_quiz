<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::get('/',[QuizController::class, 'newQuiz'])->name('index');

Route::post('/post-answer',[QuizController::class, 'postAnswer'])->name('post.answer');

