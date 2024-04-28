<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;

//Events
use App\Events\SendEmailEvent;

//Services & Repositories
use App\Domain\Interfaces\Services\Backoffice\ICRUDService;
use App\Domain\Interfaces\Repositories\Backoffice\IQuizRepository;
use App\Domain\Interfaces\Repositories\Backoffice\IResultRepository;
use App\Models\User;

//Request Validator
use App\Http\Requests\Backoffice\SurveyRequest;

//Global Classes
use Input;

class AnswerController extends Controller
{
    //Do some magic
    public function __construct(IQuizRepository $repo, ICRUDService $CRUDservice, IResultRepository $repoResult, User $user){
        $this->data = [];
        $this->repo = $repo;
        $this->user = $user;
        $this->repoResult = $repoResult;
        $this->CRUDservice = $CRUDservice;
        $this->data['title'] = 'Quiz';
        $this->difficulty = [
            'true_false' => 'questions answered by True or False',
            'multiple_choice' => 'questions with 4 multiple choice answers',
            'identification' => 'Identification questions',
        ];
        $this->difficultyFormat = [
            'true_false' => '{"questions":[{"id":0,"question":"","options":["True", "False"],"answer":""},...]}',
            'multiple_choice' => '{"questions":[{"id":0,"question":"","options":[],"answer":""},...]}',
            'identification' => '{"questions":[{"id":0,"question":"","answer":""},...]}',
        ];
        $this->data['letters'] = [ 'A)', 'B)', 'C)', 'D)', 'E)', 'F)', 'G)', 'H)' ];
    }

    public function index(){
        $this->data['results'] = $this->repoResult->pending();
        return view('backoffice.pages.answer.index',$this->data);
    }

    public function answer($id){
        $this->data['result'] = $this->repoResult->findOrFail($id);
        $this->data['quiz'] = $this->repo->findOrFail($this->data['result']->quiz_id);
        $this->data['correctAnswers'] = $this->data['quiz']->questions->pluck('answer', 'id')->toarray();
        $this->data['myAnswers'] = $this->data['result']->answers?$this->data['result']->answers->pluck('answer', 'question_id')->toarray():[];
        return view('backoffice.pages.answer.view',$this->data);
    }

    public function submitAnswer(Request $request, $id){
        if($request->quiz_btn == 'Start Answering'){
            $this->data['result'] = $this->repoResult->startAnswering($id);
        }else{
            $this->data['result'] = $this->repoResult->saveAnswer($request, $id);
        }
        return redirect()->back();
    }

    public function updateClock($id){
        $data['clock'] = $this->repoResult->updateClock($id, Input::get('_mins'), Input::get('_secs'));
        return response()->json($data,200);
    }
    
}
