<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classs;

class StudentController extends Controller
{
    
    function getList()
    {
        $class = Classs::all();
        return view('admin.student.list', ['class' => $class]);
    }

    function getAdd()
    {
        return view('admin.student.add');
    }

}
