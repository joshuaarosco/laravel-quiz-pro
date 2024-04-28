<?php

namespace App\Repositories\Backoffice;

use App\Domain\Interfaces\Repositories\Backoffice\IQuizRepository;

use App\Logic\FileUploader as UploadLogic;
use App\Models\Backoffice\Quiz as Model;
use App\Models\Backoffice\Question;
use App\Models\Backoffice\Option;
use GuzzleHttp\Client;
use DB, Str, Input;

class QuizRepository extends Model implements IQuizRepository
{

    public function fetch(){
        if(Input::has('search') AND Input::get('search') != null){
            $exploded = explode(" ",str_replace(' & ',' ',Input::get('search')));
            $query = self::query();
            foreach ($exploded as $key => $value) {
                $query->where('title', 'like', "%{$value}%")
                ->orWhere('type', 'like', "%{$value}%")
                ->orWhere('difficulty', 'like', "%{$value}%");
            }
            return $query->get();
        }
        return self::all();
    }

    public function fetchMyQuiz(){
        if(Input::has('search') AND Input::get('search') != null){
            $exploded = explode(" ",str_replace(' & ',' ',Input::get('search')));
            $query = self::query();
            foreach ($exploded as $key => $value) {
                $query->where('title', 'like', "%{$value}%")
                ->orWhere('type', 'like', "%{$value}%")
                ->orWhere('difficulty', 'like', "%{$value}%");
            }
            return $query->get();
        }
        return self::where('user_id', auth()->user()->id)->get();
    }

    public function saveData($request){
        DB::beginTransaction();
        try {
            $data = $this->where('alumni_id', auth()->user()->alumni->id)->first();
            if(!$data){
                $data = new self;
                $data->alumni_id = auth()->user()->alumni->id;
            }  

            $data->save();

            DB::commit();

            return $data;
        } catch (\Exception $e) {
             DB::rollback();
             return false;
        }
    }

    public function findOrFail($id){
        $data = $this->find($id);
        if(!$data){
            return false;
        }
        return $data;
    }

    public function deleteData($id){
        DB::beginTransaction();
        try {
            $this->deleteQuestions($id);
            $this->destroy($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function createQuiz(){
        DB::beginTransaction();
        try {
            $quiz = new self;
            $quiz->user_id = auth()->user()->id;
            $quiz->save();

            DB::commit();
            return $quiz;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function patchQuiz($id){
        $data = self::find($id);
        $data->title = Input::get('_title');
        $data->time_limit = Input::get('_tl');
        $data->no_of_questions = Input::get('_nof');
        $data->difficulty = Input::get('_diff');
        $data->save();
        if(!$data){
            return false;
        }
        return $data;
    }

    public function saveQuiz($request, $id){
        DB::beginTransaction();
        try {
            $quiz = self::find($id);
            
            $this->deleteQuestions($id);

            if($request->btn_submit == 'publish'){
                $quiz->status = 'publish';
            }

            $quiz->save();

            if($request->has('quiz_file')){
                $upload = UploadLogic::upload($request->quiz_file,'storage/quiz_file');
                $about = $this->getText($upload);
                $genQuestions = json_decode(json_decode($this->genQuestions($request, $about))->choices[0]->message->content);
                
                foreach($genQuestions->questions as $index => $question){
                    $newQuestion = new Question;
                    $newQuestion->quiz_id = $id;
                    $newQuestion->question = $question->question;
                    $newQuestion->answer = $question->answer;
                    $newQuestion->save();

                    if($quiz->difficulty != 'identification'){
                        foreach($question->options as $option){
                            $newOption = new Option;
                            $newOption->question_id = $newQuestion->id;
                            $newOption->option = $option;
                            $newOption->save();
                        }
                    }
                }
            }else{
                foreach($request->question as $index => $question){
                    $newQuestion = new Question;
                    $newQuestion->quiz_id = $id;
                    $newQuestion->question = $question;
                    $newQuestion->answer = $request->answer[$index];
                    $newQuestion->save();

                    if($quiz->difficulty != 'identification'){
                        foreach($request->options[$index] as $option){
                            $newOption = new Option;
                            $newOption->question_id = $newQuestion->id;
                            $newOption->option = $option;
                            $newOption->save();
                        }
                    }
                }
            }

            DB::commit();
            return $quiz;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function deleteQuestions($id){
        $questions = Question::where('quiz_id', $id)->get();
        foreach($questions as $question){
            
            $options = Option::where('question_id', $question->id)->get();
            foreach($options as $option){
                $option->delete();
            }
            $question->delete();
        }
    }

    public function getText($upload){
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($upload['path']."/".$upload['filename']);

        return $pdf->getText();
    }

    public function genQuestions($request, $about){
        $difficulty = [
            'true_false' => 'questions answered by True or False',
            'multiple_choice' => 'questions with 4 multiple choice answers',
            'identification' => 'Identification questions',
        ];
        $difficultyFormat = [
            'true_false' => '{"questions":[{"id":0,"question":"","options":["True", "False"],"answer":""},...]}',
            'multiple_choice' => '{"questions":[{"id":0,"question":"","options":[],"answer":""},...]}',
            'identification' => '{"questions":[{"id":0,"question":"","answer":""},...]}',
        ];

        $content = 'You are a quiz master. Generate '.$request->no_of_questions.' '.$difficulty[$request->difficulty].' about the following context "'.$about.'". Also provide the answer separately. '.
                    'The response should be in the following json format:'.$difficultyFormat[$request->difficulty];
        
        return $this->chatGPT($content);
    }

    private function chatGPT($content){
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
    
}
