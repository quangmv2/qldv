<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Classs;
use App\Student;
use App\DotXetDiem;
use App\SchoolYear;
use App\Point;
use App\TempPoint;

class DotXetDiemController extends Controller
{
    function getAdd(Request $request)
    {
        $id_student = $request->session()->get('account')->id_student;
        $student = Student::where('id_student', $id_student)->get()[0];
        $year = SchoolYear::all();
        return view('client.point.add', ['year' => $year]);
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
        $dot->nam_hoc = $request->input('year');
        $dot->hoc_ki = $request->input('semester');
        $dot->ngay_bat_dau = $request->input('begin');
        $dot->ngay_ket_thuc = $request->input('end');
        $dot->id_class = $request->session()->get('account')->id_class;
        $dot->save();

        $students = Student::join('class', 'class.id_class', '=', 'students.id_class')
        ->where('class.id_class', $request->session()->get('account')->id_class)
        ->select('students.*')
        ->get();
        foreach ($students as $key => $value) {
            $point = new Point;
            $point->id_dot = $dot->id_dot_xet;
            $point->id_student = $value->id_student;
            $point->confirm = 0;
            $point->total = 0;
            $point->save();

            $temp_point = new TempPoint;
            $temp_point->id_dot = $dot->id_dot_xet;
            $temp_point->id_student = $value->id_student;
            $temp_point->confirm = 0;
            $temp_point->total = 0;
            $temp_point->save();
        }
        echo $students->tojson();
        return;

        return back()->with('notification', 'Thêm thành công');
    }

    public function danhSachDot(Request $request)
    {
        if (empty($request->input('page'))){
            $page = 1;
        } else{
            $page = $request->input('page');
        }

        $list = DotXetDiem::where('id_class', $request->session()->get('account')->id_class)->paginate(20);
        if ($request->input('type') == 'ajax') {
            return view('client.point.ajax.danh_sach_dot', ['list' => $list]);
        } else {
            return view('client.point.danh_sach_dot');
        }
    }

    public function getDot(Request $request, $id_dot)
    {

        $students = Point::where('id_dot', $id_dot)
        ->join('students', 'students.id_student', '=', 'points.id_student')
        ->join('profiles', 'profiles.id_profile', '=', 'students.id_profile')
        ->orderby('last_name')
        ->select('*')
        ->get();

        // return $students->tojson();

        return view('client.point.list_sinh_vien_dot',["students" => $students, 'id_dot' => $id_dot]);
    }

    public function delete(Request $request, $id_dot){

        $dot = DotXetDiem::find($id_dot);
        if (empty($dot)) return back();
        DotXetDiem::find($id_dot)->delete();
        return back();

    }

}
