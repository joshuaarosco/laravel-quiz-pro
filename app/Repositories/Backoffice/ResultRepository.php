<?php

namespace App\Repositories\Backoffice;
use App\Domain\Interfaces\Repositories\Backoffice\IResultRepository;

use App\Logic\ImageUploader as UploadLogic;
use App\Models\Backoffice\Result as Model;
use App\Models\Backoffice\Answer;
use App\Models\Backoffice\Quiz;
use App\Models\Backoffice\Student;
use DB, Str, Input;

class ResultRepository extends Model implements IResultRepository
{

    public function fetch(){
        return $this->all();
    }

    public function pending(){
        return $this->where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get();
    }

    public function saveData($request){
        DB::beginTransaction();
        try {
            $data = $this->find($request->id)?:new self;

            $data->title = $request->title;
            $data->date = $request->date;
            $data->content = $request->content;
            
            if($request->hasFile('file')){
                $upload = UploadLogic::upload($request->file,'storage/events');
                $data->path = $upload["path"];
                $data->directory = $upload["directory"];
                $data->filename = $upload["filename"];
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
            $this->destroy($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function assignStudent($request){
        DB::beginTransaction();
        try {
            $quiz = Quiz::find($request->quiz_id);
            $selected_user_ids = $request->has('user_id')? $request->user_id : [];
            $userIdsToDelete = [];
            $user_ids = self::where('quiz_id', $request->quiz_id)->pluck('user_id')->toArray();
            
            foreach($selected_user_ids as $user_id){
                $check = self::where('quiz_id', $request->quiz_id)->where('user_id', $user_id)->first();
                
                if(!$check){
                    $result = new self;
                    $result->quiz_id = $request->quiz_id;
                    $result->user_id = $user_id;
                    $result->minute = $quiz->time_limit;
                    $result->save();
                }
            }

            foreach($user_ids as $user_id){
                if(!in_array($user_id, $selected_user_ids)){
                    $result = self::where('user_id', $user_id)->where('quiz_id', $request->quiz_id)->first();
                    $answer = Answer::where('result_id', $result)->first();

                    if($answer){
                        $answer->delete();
                    }

                    $result->delete();
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function saveAnswer($request, $id){
        DB::beginTransaction();
        try {
            $result = self::find($id);

            if($result->status == 'on_going'){
                $questions = $result->quiz->questions->pluck('answer', 'id')->toarray();
                foreach($request->question_id as $question_id){
                    $answer = new Answer;
                    $answer->result_id = $id;
                    $answer->question_id = $question_id;
                    if($request->has('answers')){
                        if(array_key_exists($question_id, $request->answers)){
                            $answer->answer = $request->answers[$question_id];
                            $answer->is_correct = $request->answers[$question_id] == $questions[$question_id]?true:false;
                        }
                    }
                    $answer->save();
                }
            }

            $result->status = 'completed';
            $result->save();
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function startAnswering($id){
        DB::beginTransaction();
        try {
            $result = self::find($id);
            $result->status = 'on_going';
            $result->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function updateClock($id, $mins, $secs){
        DB::beginTransaction();
        try {
            $result = self::find($id);
            $result->minute = $mins;
            $result->seconds = $secs;
            $result->save();
            DB::commit();
            return [
                'id' => $result->id,
                'minute' => $result->minute,
                'seconds' => $result->seconds,
            ];

        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function studentResult($id){
        $results = self::where('quiz_id', $id)->pluck('user_id')->toArray();

        if(Input::has('search') AND Input::get('search') != null){
            $exploded = explode(" ",str_replace(' & ',' ',Input::get('search')));
            $query = Student::query();
            foreach ($exploded as $key => $value) {
                $query->where('lname', 'like', "%{$value}%")
                ->orWhere('fname', 'like', "%{$value}%")
                ->orWhere('course', 'like', "%{$value}%")
                ->orWhere('section', 'like', "%{$value}%")
                ->orWhere('school_year', 'like', "%{$value}%");
            }
            return $query->orderBy('lname', 'ASC')->whereIn('user_id', $results)->get();
        }
        return Student::orderBy('lname', 'ASC')->whereIn('user_id', $results)->get();
    }

    public function results($id){
        $results = self::where('quiz_id', $id)->get();
        $userResults = [];
        foreach($results as $result){
            $userResults[$result->user_id] = $result;
        }
        return $userResults;
    }
}
