<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;
use Log;

class QuizController extends Controller
{
    protected $url = "https://countriesnow.space/api/v0.1/countries/capital";

    public function newQuiz(){

        $single_quiz = $this->pickNew();

        return view('index',compact('single_quiz'));
    }

    private function pickNew(){

        $raw_response = $this->datasource();

        $raw_response = $raw_response['data'];

        return $raw_response;
    }

    // I'll handle cache and download api response
    private function datasource(){

        $raw_response = Http::get($this->url);

        return $raw_response;

    }


}
