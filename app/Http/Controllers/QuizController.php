<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;
use Log;
use Cache;
use App\Http\Requests\AnswerValidationRequest;
use App\Models\User;

class QuizController extends Controller
{
    protected $url = "https://countriesnow.space/api/v0.1/countries/capital";

    // Web.php Call

    public function newQuiz()
    {
        $single_quiz = $this->pickNew();

        $existingToken = request()->header('Authorization');

        if ($existingToken) {
            $existingToken = str_replace('Bearer ', '', $existingToken);
            $isValid = auth()->checkTokenValidity($existingToken); 
            if ($isValid) {
                return view('welcome', compact('single_quiz', 'existingToken'));
            }
        }

        $user = User::first(); 
        $token = $user->createToken('api-token')->plainTextToken;

        return view('welcome', compact('single_quiz', 'token'));
    }


    public function postAnswer(AnswerValidationRequest $request)
    {
        Log::info(gettype($request));
        Log::info($request->all());
    
        if (!session()->has('current_capital')) {
            return response()->json(['message' => 'Session Expired'], 401);
        }
    
        $submittedCapital = $request->input('capital');
        $correctCapital = session('current_capital');
    
        if ($correctCapital === $submittedCapital) {
            return response()->json(['message' => 'correct'], 200);
        } else {
            return response()->json([
                'message' => 'not correct',
                'correct_capital' => $correctCapital
            ], 200);
        }
    }

    /**
     * Responsible to Pick a Question includes 3 
     */
    private function pickNew(){

        try {
            $raw_response = $this->datasource()['data'];
        } catch (\Exception $e) {
            Log::error('Exception while fetching country capitals:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }

        

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

        // Assuming Question check for all validity now put a correct capital in session for quick compare
        session(['current_capital' => $random_q_obj['capital']]);

        Log::info(session('current_capital'));

        return [
            'country'=> $random_country,
            'capitals'=> $capital_obj_arr
        ];
    }

    // I'll handle cache and download the external api response //
    private function datasource()
    {
        try {
            // Cache::flush();
            $raw_response = Cache::remember('country_response', 3600, function () {
                try {
                    $response = Http::timeout(10)->get($this->url);
    
                    if ($response->failed()) {
                        Log::error('Failed to fetch country capitals.', [
                            'status' => $response->status(),
                            'body' => $response->body(),
                        ]);
                        return null; // Or return a default structure if preferred
                    }
    
                    return $response->json();
                } catch (\Exception $e) {
                    Log::error('Exception while fetching country capitals:', [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    return null;
                }
            });
        } catch (\Exception $e) {
            Log::error('Exception in datasource method:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $raw_response = null;
        }
    
        Log::info('QuizController->datasource()');
        Log::info('Type of raw_response:', ['type' => gettype($raw_response)]);
    
        return $raw_response;
    }

    // api.php Call (protected)
    public function questionViaApi()
    {
        try {
            $single_quiz = $this->pickNew();
            return response()->json([
                'success' => true,
                'data' => $single_quiz
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching new quiz question: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to fetch quiz question at this time.'
            ], 500);
        }
    }

}
