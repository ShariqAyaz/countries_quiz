<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::middleware('auth:sanctum')->get('/new-question', [QuizController::class,'questionViaApi']);
