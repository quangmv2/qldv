<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Student;

class ClientController extends Controller
{
    public function __construct(Request $request)
    {
        // $id_student = $request->session()->get('account')->id_student;
        // $student = Student::where('id_student', $id_student)->get()->first();
        // return $student;
        // View::share('index_id_student', $student);
    }
}
