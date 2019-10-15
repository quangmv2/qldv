<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    
    function getList()
    {
       return view('admin.student.list');
    }

    function getAdd()
    {
        return view('admin.student.add');
    }

}
