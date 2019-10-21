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
        $teachers = Teacher::join('profiles', 'profiles.id_profile', '=', 'teachers.id_profile')->orderby('profiles.last_name')->orderby('profiles.first_name')->select('teachers.*')->get();
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
        $class->name = strtoupper($request->input('name'));
        $class->teacher = $request->input('teacher');
        $class->start_study = $request->input('begin');
        $class->end_study = $request->input('end');
        $class->save();
        return redirect()->route('adminListClass')->with('notification', "Thêm thành công lớp học ".$class->name.".");
    }

    function getEdit(Request $request, $class)
    {
        $class = Classs::where('name', $class)->get();
        if (!count($class)>0) return redirect()->route('adminListClass')->with('myError', "Không tìm thấy lớp học.");
        $teachers = Teacher::all();
        return view('admin.class.edit', ['teachers'=>$teachers, 'class'=>$class[0]]);
    }

    function postEdit(Request $request, $class)
    {
        $class = Classs::where('name', $class)->get();
        if (!count($class)>0) return redirect()->route('adminListClass')->with('myError', "Không tìm thấy lớp học.");
        $class = $class[0];
        if (strtoupper($request->input('name')) == strtoupper($class->name)) goto nextED;
        $this->validate($request, [
            'name' => 'required|unique:class,name',
        ],
        [
            'name.required' => "Bạn chưa nhập tên lớp.",
            'name.unique' => "Lớp đã tồn tại.",
        ]);
        nextED: 
        $this->validate($request, [
            'teacher' => 'required',
            'begin' => 'required|date',
            'end' => 'required|date',
        ],
        [
            'teacher.required' => "Chưa chọn Giảng viên chủ nhiệm.",
            'begin.required' => "Chưa chọn ngày bắt đầu.",
            'begin.date' => "Sai kiểu dữ liệu ngày.",
            'end.required' => "Chưa chọn ngày kết thúc.",
            'end.date' => "Sai kiểu dữ liệu giờ",
        ]);

        $arr = [
            'name' => strtoupper($request->input('name')),
            'teacher' => $request->input('teacher'),
            'start_study' => $request->input('begin'),
            'end_study' => $request->input('end'),
        ];

        Classs::where('name', $class->name)->update($arr);
        return redirect()->route('adminListClass')->with('notification', "Cập nhật thành công thông tin lớp học ".$class->name.".");

    }

}
