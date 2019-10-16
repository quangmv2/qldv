<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Classs;
use App\Student;
use App\Position;
use App\User;
use App\Profile;

class StudentController extends Controller
{
    
    function getList()
    {
        $students = Student::all();
        $class = Classs::all();
        return view('admin.student.list', ['class' => $class, 'students' => $students]);
    }

    function getAdd()
    {
        $class = Classs::all();
        $positions = Position::all();
        return view('admin.student.add', ['class' => $class, 'positions' => $positions]);
    }

    function postAdd(Request $request)
    {
        $this->validate($request, [
            'id_student' => 'required|unique:students,id_student',
            'name' => 'required',
            'birthday' => 'required|date',
            'phone_number' => 'regex:/(0)[0-9]{9}/',
            'class' => 'required',
            'address' => 'required',
        ],
        [
            'id_student.required' => "Bạn chưa nhập mã sinh viên.",
            'id_student.unique' => "Mã sinh viên đã tồn tại.",
            'name.required' => "Chưa nhập tên sinh viên.",
            'birthday.required' => "Chưa nhập ngày sinh.",
            'birthday.date' => "Sai kiểu dữ liệu ngày.",
            'phone_number.regex' => "Sai kiểu dữ liệu số điện thoại.",
            'class.required' => "Chưa chọn lớp học.",
            'address.required' => "Chưa nhập địa chỉ.",
        ]);

        $class = Classs::where('id', $request->input('class'))->get();
        if (!count($class) > 0) return back()->with('myError', "Lớp học không tồn tại");
        $position = Position::where('id', $request->input('position'))->get();
        if (!count($position) > 0) return back()->with('myError', "Chức vụ không tồn tại");
        $email = createEmailStudent($request->input('name'), $class[0]->name);
        $rd = Str::random(9);
    
        $user = new User;
        $user->email = $email;        
        $user->password =  password_hash($rd, PASSWORD_BCRYPT);
        $user->type = 0;
        $user->save();

        $profile = new Profile;
        $profile->name = $request->input('name');
        $profile->phone_number = $request->input('phone_number');
        $profile->address = $request->input('address');
        $profile->birthday = $request->input('birthday');
        $profile->email = $email;
        $profile->save();

        $student = new Student;
        $student->id = $profile->id;
        $student->id_student = $request->input('id_student');
        $student->id_class = $request->input('class');
        $student->position = $request->input('position');
        $student->save();

        return redirect()->route('adminListStudent')->with('notification', "Thêm thành công sinh viên ".$profile->name.".");

    }

}
