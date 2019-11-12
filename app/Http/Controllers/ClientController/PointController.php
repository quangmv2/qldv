<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Classs;
use App\Student;
use App\DotXetDiem;
use App\SchoolYear;

class PointController extends Controller
{
    function getAdd(Request $request)
    {
        $id_student = $request->session()->get('account')->id_student;
        $student = Student::where('id_student', $id_student)->get()[0];
        // $class = $student->classs;
        // $begin = Carbon::parse($class->start_study)->format('Y');
        // $end = Carbon::parse($class->end_study)->format('Y');
        // $arr = [];
        // for ($i=$begin; $i < $end; $i++) { 
        //     $arr[] = $i."-".($i+1);
        // }
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
        $dot->save();
        return back()->with('notification', 'Thêm thành công');

    }

    public function danhSachDot(Request $request)
    {
        if (empty($request->input('page'))){
            $page = 1;
        } else{
            $page = $request->input('page');
        }

        $list = DotXetDiem::paginate(20);
        if ($request->input('type') == 'ajax') {
            return view('client.point.ajax.danh_sach_dot', ['list' => $list]);
        } else {
            return view('client.point.danh_sach_dot');
        }
    }

}
