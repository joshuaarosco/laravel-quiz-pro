<?php

namespace App\Repositories\Backoffice;
use App\Domain\Interfaces\Repositories\Backoffice\IProfessorRepository;

use App\Logic\ImageUploader as UploadLogic;
use App\Models\Backoffice\Professor;
use App\Models\User as Model;
use Input;
use DB, Str;

class ProfessorRepository extends Model implements IProfessorRepository
{
    
    public function fetch(){
        if(Input::has('search') AND Input::get('search') != null){
            $exploded = explode(" ",str_replace(' & ',' ',Input::get('search')));
            $query = Professor::query();
            foreach ($exploded as $key => $value) {
                $query->where('fname', 'like', "%{$value}%")
                ->orWhere('lname', 'like', "%{$value}%")
                ->orWhere('department', 'like', "%{$value}%");
            }
            return $query->get();
        }
        return Professor::all();
    }
    
    public function saveData($request){
        DB::beginTransaction();
        try {
            $user = $this->find($request->user_id);
            $professor = $user? Professor::where('user_id', $user->id)->first() : null;

            if(!$user){
                $user = new self;
                $user->password = bcrypt($request->password);
            }

            $user->name = $request->fname.' '.$request->lname;
            $user->username = $request->email;
            $user->type = 'professor';
            $user->email = $request->email;
            $user->contact_number = $request->contact_number;
            
            $user->save();

            if(!$professor){
                $professor = new Professor;
                $professor->user_id = $user->id;
            }

            $professor->fname = $request->fname;
            $professor->lname = $request->lname;
            $professor->department = $request->department;
            
            if($request->hasFile('file')){
                $upload = UploadLogic::upload($request->file,'storage/professor');
                $professor->path = $upload["path"];
                $professor->directory = $upload["directory"];
                $professor->filename = $upload["filename"];
            }
            
            $professor->save();
            
            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
    
    public function findOrFail($id){
        $data = Professor::find($id);
        if(!$data){
            return false;
        }
        return $data;
    }
    
    public function deleteData($id){
        DB::beginTransaction();
        try {
            Professor::destroy($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
    
    public function checkProfessor($request){
        DB::beginTransaction();
        try {
            $alumni = Professor::where('lname', $request->lname)->where('email', $request->email)->first();
            
            if(!$alumni){
                session()->flash('notification-status', "danger");
                session()->flash('notification-msg', 'The Professor details you provided does not exist on our list. Please complete your clearance.');
                return false;
            }
            $user = self::where('username', $request->email)->first();
            $password = Str::random(8);
            if(!$user){
                session()->flash('notification-status', "danger");
                session()->flash('notification-msg', 'The Professor details you provided does not exist on our list. Please complete your clearance.');
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
