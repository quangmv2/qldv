<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Classs;
use App\Student;
use App\DotXetDiem;

class PointController extends Controller
{
    function getAdd(Request $request)
    {
        $id_student = $request->session()->get('account')->id_student;
        $student = Student::where('id_student', $id_student)->get()[0];
        $class = $student->classs;
        $begin = Carbon::parse($class->start_study)->format('Y');
        $end = Carbon::parse($class->end_study)->format('Y');
        $arr = [];
        for ($i=$begin; $i < $end; $i++) { 
            $arr[] = $i."-".($i+1);
        }
        return view('client.point.add', ['arr' => $arr]);
    }

    function postAdd(Request $request)
    {
        $this->validate($request, 
        [

        ],
        [

        ]);

        $dot = new DotXetDiem;
        $dot->ten_dot = $request->input('name');
        $dot->

    }
}
