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
use App\Domain\Interfaces\Repositories\Backoffice\IStudentRepository;
use App\Models\User;

//Request Validator
use App\Http\Requests\Backoffice\SurveyRequest;

//Global Classes
use Input;

class QuizController extends Controller
{
    //Do some magic
    public function __construct(IQuizRepository $repo, ICRUDService $CRUDservice, User $user, IStudentRepository $studentRepo, IResultRepository $resultRepo){
        $this->data = [];
        $this->repo = $repo;
        $this->user = $user;
        $this->resultRepo = $resultRepo;
        $this->studentRepo = $studentRepo;
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
        $this->data['quizzes'] = auth()->user()->type != 'professor'? $this->repo->fetch():$this->repo->fetchMyQuiz();
        return view('backoffice.pages.quiz.index',$this->data);
    }

    public function create(){
        $quiz = $this->repo->createQuiz();
        return redirect()->route('backoffice.quiz.view', $quiz->id);
    }

    public function view($id){
        $this->data['quiz'] = $this->repo->findOrFail($id);
        return view('backoffice.pages.quiz.create',$this->data);
    }

    public function patch(){
        $data['datas'] = $this->repo->patchQuiz(Input::get('_id'));
        return response()->json($data,200);
    }

    public function genQuestions($type){
        $about = Input::get('_context');
        $noOfQuestions = Input::get('_nof');
        $difficulty = Input::get('_diff');
        
        $content = 'You are a quiz master. Generate '.$noOfQuestions.' '.$this->difficulty[$difficulty].' about the following '.$type.' "'.$about.'". Also provide the answer separately. '.
                    'The response should be in the following json format:'.$this->difficultyFormat[$difficulty]; 

        $data['quiz'] = json_decode($this->chatGPT($content));
        
        return response()->json($data,200);
    }

    public function saveQuiz(Request $request, $id){
        $quiz = $this->repo->saveQuiz($request, $id);
        return redirect()->route('backoffice.quiz.view', $id);
    }

    public function chatGPT($content){
        $client = new Client();

        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('CHAT_GPT_KEY'),
            ],
            'json' => [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $content,
                    ],
                ],
                'temperature' => 0,
                // 'max_tokens' => 2048,
            ],
        ]);

        $body = $response->getBody()->getContents();
        return $body;
    }

    public function delete($id){
        $quiz  = $this->CRUDservice->delete($id, $this->repo);
        return redirect()->back();
    }

    public function assign($id){
        $this->data['quiz'] = $this->repo->findOrFail($id);
        $this->data['students'] = $this->studentRepo->fetch();
        return view('backoffice.pages.quiz.assign', $this->data);
    }

    public function assignStudent(Request $request, $id){
        if(!$request->has('user_id')){
            session()->flash('notification-status','warning');
            session()->flash('notification-msg',"Please select some Student.");
            return redirect()->back();
        }
        $this->data = $this->resultRepo->assignStudent($request);
        return redirect()->back();
    }

    public function results($id){
        $this->data['quiz'] = $this->repo->findOrFail($id);
        $this->data['students'] = $this->resultRepo->studentResult($id);
        $this->data['results'] = $this->resultRepo->results($id);
        return view('backoffice.pages.quiz.results', $this->data);
    }
}
