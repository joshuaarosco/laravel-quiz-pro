<?php

namespace App\Repositories\Backoffice;
use App\Domain\Interfaces\Repositories\Backoffice\IStudentRepository;

use App\Logic\ImageUploader as UploadLogic;
use App\Models\Backoffice\Student;
use App\Models\User as Model;
use Input;
use DB, Str;

class StudentRepository extends Model implements IStudentRepository
{
    public function fetch(){
        if(Input::has('search') AND Input::get('search') != null){
            $exploded = explode(" ",str_replace(' & ',' ',Input::get('search')));
            $query = Student::query();
            foreach ($exploded as $key => $value) {
                $query->where('fname', 'like', "%{$value}%")
                ->orWhere('lname', 'like', "%{$value}%")
                ->orWhere('course', 'like', "%{$value}%")
                ->orWhere('section', 'like', "%{$value}%")
                ->orWhere('school_year', 'like', "%{$value}%");
            }
            return $query->orderBy('lname', 'ASC')->get();
        }
        return Student::orderBy('lname', 'ASC')->get();
    }

    public function fetchStudents($id){
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
            return $query->orderBy('lname', 'ASC')->get();
        }
        return Student::orderBy('lname', 'ASC')->get();
    }
    
    public function saveData($request){
        DB::beginTransaction();
        try {
            $user = $this->find($request->user_id);
            $student = $user? Student::where('user_id', $user->id)->first() : null;

            if(!$user){
                $user = new self;
                $user->password = bcrypt($request->password);
            }

            $user->name = $request->fname.' '.$request->lname;
            $user->username = $request->email;
            $user->type = 'student';
            $user->email = $request->email;
            $user->contact_number = $request->contact_number;
            
            $user->save();

            if(!$student){
                $student = new Student;
                $student->user_id = $user->id;
            }

            $student->fname = $request->fname;
            $student->lname = $request->lname;
            $student->id_number = $request->id_number;
            $student->course = $request->course;
            $student->section = $request->section;
            $student->school_year = $request->school_year;
            
            if($request->hasFile('file')){
                $upload = UploadLogic::upload($request->file,'storage/student');
                $student->path = $upload["path"];
                $student->directory = $upload["directory"];
                $student->filename = $upload["filename"];
            }
            
            $student->save();
            
            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
    
    public function findOrFail($id){
        $data = Student::find($id);
        if(!$data){
            return false;
        }
        return $data;
    }
    
    public function deleteData($id){
        DB::beginTransaction();
        try {
            Student::destroy($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
    
    public function checkStudent($request){
        DB::beginTransaction();
        try {
            $student = Student::where('lname', $request->lname)->where('email', $request->email)->first();
            
            if(!$student){
                session()->flash('notification-status', "danger");
                session()->flash('notification-msg', 'The Student details you provided does not exist on our list. Please complete your clearance.');
                return false;
            }
            $user = self::where('username', $request->email)->first();
            $password = Str::random(8);
            if(!$user){
                session()->flash('notification-status', "danger");
                session()->flash('notification-msg', 'The Student details you provided does not exist on our list. Please complete your clearance.');
                return false;
            }
            
            $user->password = bcrypt($password);
            $user->save();
            
            DB::commit();

            $user->password = $password;
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}
