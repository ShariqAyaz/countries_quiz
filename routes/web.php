<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::get('/',[QuizController::class, 'newQuiz']);

// Submit Quiz (Post)

