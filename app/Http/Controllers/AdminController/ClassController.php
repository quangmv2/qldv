<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Teacher;

class ClassController extends Controller
{
    function getList()
    {
        return view('admin.class.list');
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
        return back();
    }
}
