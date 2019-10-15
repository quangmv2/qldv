<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Teacher;
use App\Classs;

class ClassController extends Controller
{
    function getList()
    {
        $class = Classs::all();
        return view('admin.class.list',['class' => $class]);
    }

    function getAdd()
    {       
        $teachers = Teacher::all();
        return view('admin.class.add', ['teachers'=>$teachers]);
    }

    function postAdd(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:class,name',
            'teacher' => 'required',
            'begin' => 'required|date',
            'end' => 'required|date',
        ],
        [
            'name.required' => "Bạn chưa nhập tên lớp.",
            'name.unique' => "Lớp đã tồn tại.",
            'teacher.required' => "Chưa chọn Giảng viên chủ nhiệm.",
            'begin.required' => "Chưa chọn ngày bắt đầu.",
            'begin.date' => "Sai kiểu dữ liệu ngày.",
            'end.required' => "Chưa chọn ngày kết thúc.",
            'end.date' => "Sai kiểu dữ liệu giờ",
        ]);
        $class = new Classs;
        $class->name = $request->input('name');
        $class->teacher = $request->input('teacher');
        $class->start_study = $request->input('begin');
        $class->end_study = $request->input('end');
        $class->save();
        return redirect()->route('adminListClass');
    }
}
