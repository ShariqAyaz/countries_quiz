<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;
use Log;
use Cache;

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

    // I'll handle cache and download api response //
    private function datasource(){

        // Cache::flush();
        // https://laravel.com/docs/11.x/cache#retrieve-store
        $raw_response = Cache::remember('country_response', (60*60), function () {
            $response = Http::get($this->url);
            return $response;
        });

        Log::info('QuizController->datasource()');
        Log::info($raw_response);
        

        return $raw_response;
    }


}
