<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Domain\Interfaces\Repositories\Backoffice\ISurveyRepository;
use App\Domain\Interfaces\Repositories\Backoffice\IAlumniRepository;
use App\Domain\Interfaces\Repositories\Backoffice\IEventsRepository;

class DashboardController extends Controller
{
    public function __construct(){
        $this->data['title'] = 'Dashboard';
    }
    //Do some magic
    public function index(){
    	return view('backoffice.index', $this->data);
    }
}
