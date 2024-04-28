<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Events
use App\Events\SendEmailEvent;

//Services & Repositories
use App\Domain\Interfaces\Services\Backoffice\ICRUDService;
use App\Domain\Interfaces\Repositories\Backoffice\IProfessorRepository;

//Request Validator
use App\Http\Requests\Backoffice\ProfessorRequest;

//Global Classes
use Input;

class ProfessorController extends Controller
{
    //Do some magic
    public function __construct(IProfessorRepository $repo, ICRUDService $CRUDservice){
        $this->data = [];
        $this->repo = $repo;
        $this->CRUDservice = $CRUDservice;
        $this->data['title'] = 'Instructor';
    }

    public function index(){
        $this->data['professors'] = $this->repo->fetch();
        return view('backoffice.pages.professors.index',$this->data);
    }

    public function create(ProfessorRequest $request){
        $crudData = $this->CRUDservice->save($request, $this->repo);
        if($crudData){
            event(new SendEmailEvent($crudData,'alumni_creation'));
        }
        return redirect()->back();
    }

    public function edit(){
        $data['datas'] = $this->repo->findOrFail(Input::get('_id'));
        return response()->json($data,200);
    }

    public function update(Request $request){
        $crudData = $this->CRUDservice->save($request, $this->repo);
        return redirect()->back();
    }

    public function delete($id){
        return $this->CRUDservice->delete($id, $this->repo);
    }
}
