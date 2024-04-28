<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Domain\Interfaces\Repositories\Backoffice\IProfessorRepository;
use App\Domain\Interfaces\Repositories\Backoffice\IStudentRepository;

use App\Domain\Interfaces\Services\Backoffice\ICRUDService;

//Request Validator
use App\Http\Requests\Backoffice\RegisterRequest;
use Auth;

class RegisterController extends Controller
{
    public function __construct(IStudentRepository $studentRepo, IProfessorRepository $professorRepo, ICRUDService $crudService){
        $this->data['title'] = 'Register';
        $this->studentRepo = $studentRepo;
        $this->professorRepo = $professorRepo;
        $this->crudService = $crudService;
    }
    //Do some magic
    public function index($user_type){
        if(!in_array($user_type, ['professor', 'student'])){
            return abort('404');
        }
        $this->data['user_type'] = $user_type;
    	return view('backoffice.auth.register', $this->data);
    }

    public function register(RegisterRequest $request){
        $crudData = null;
        if($request->user_type == 'student'){
            $crudData = $this->crudService->save($request, $this->studentRepo);
        }
        if($request->user_type == 'professor'){
            $crudData = $this->crudService->save($request, $this->professorRepo);
        }
        if(!$crudData){
            return abort('404');
        }

        Auth::loginUsingId($crudData->id);
        return redirect()->route('backoffice.auth.login');
    }
}
