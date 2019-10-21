<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ActionsRequest;
use Validator;

use Carbon\Carbon;
use App\Student;
use App\Action;
use App\Classs;


class ActionController extends Controller
{
    function getList()
    {
        
    }

    function getAdd()
    {
        $students = Student::join('profiles', 'profiles.id', '=', 'students.id')->select('students.*')->orderby('profiles.last_name', 'asc')->orderby('profiles.first_name', 'asc')->get();
        return view('client.action.add', ['students' => $students]);
    }

    function postAdd(ActionsRequest $request)
    {
        
        $validator = $request->validated();
        $action = new Action;
        $action->name = $request->input('name');
        $action->time = $request->input('time');
        $action->content = $request->input('content');
        $action->id_class = 4;
        $action->confirm = 0;

        if ($request->input('object') == 0){
            $students = Student::join('class', 'students.id_class', '=', 'class.id')->where('class.id', 4)->select('students.*')->get();
            
            echo $students->tojson();
        }

        if ($request->input('object') == 1){
            $arr = $request->input('id_student');

            return json_encode($arr);
        }
    
    }
    
}
