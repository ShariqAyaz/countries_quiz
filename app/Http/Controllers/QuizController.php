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

    public function postAnswer(Request $request){

        Log::info(gettype($request));
        Log::info($request->all());

    }

    /**
     * Responsible to Pick a Question includes 3 
     */
    private function pickNew(){

        $raw_response = $this->datasource()['data'];

        return $this->findNewQuestion($raw_response);
    }

    protected function findNewQuestion(Array $arr){

        $random_q_obj = collect($arr)->random();

        $random_country= $random_q_obj['name'];
        $capital_obj_arr[] = $random_q_obj['capital'];

        $i =0;
        while($i < 2){
            $_random = collect($arr)->random()['capital'];
            if ($random_q_obj['capital'] !== $_random){
                $capital_obj_arr[] = $_random;
            }
            $i++;
        }

        // Correct capital always on top // need to shuffle it
        // https://laravel.com/docs/11.x/helpers#method-array-shuffle
        shuffle($capital_obj_arr);

        return [
            'country'=> $random_country,
            'capitals'=> $capital_obj_arr
        ];
    }

    // I'll handle cache and download api response //
    private function datasource(){

        // Cache::flush();
        // https://laravel.com/docs/11.x/cache#retrieve-store 
        $raw_response = Cache::remember('country_response', (60*60), function () {

            $response = Http::timeout(10)->get($this->url);

            if ($response->failed()) {
                return null;
            }

            return $response->json();
        });

        Log::info('QuizController->datasource()');
        Log::info(gettype($raw_response)); // arry

        return $raw_response;
    }

}
