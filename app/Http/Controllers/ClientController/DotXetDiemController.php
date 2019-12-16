<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\ClientController\ClientController;
use Illuminate\Http\Request;

use Validator;
use Carbon\Carbon;
use PDF;

use App\Classs;
use App\Student;
use App\DotXetDiem;
use App\SchoolYear;
use App\Point;
use App\MyPoint;

class DotXetDiemController extends ClientController
{
    function getAdd(Request $request)
    {


        // $point = MyPoint::all();
        // foreach ($point as $key => $item) {
        //     $value = Point::where('id_student', $item->id_student)->where('id_dot', $item->id_dot)->get()->first();
        //     $arr_update = [
        //         "p1a" => $value->p1a,
        //         "p1b1" => $value->p1b1,
        //         "p1b2" => $value->p1b2,
        //         "p1c" => $value->p1c,
        //         "p1d" => $value->p1d,
        //         "p1dd" => $value->p1dd,
        //         "p2a1" => $value->p2a1,
        //         "p2a2" => $value->p2a2,
        //         "p2b1" => $value->p2b1,
        //         "p2b2" => $value->p2b2,
        //         "p2b3" => $value->p2b3,
        //         "p3a1" => $value->p3a1,
        //         "p3a2" => $value->p3a2,
        //         "p3b1" => $value->p3b1,
        //         "p3b2" => $value->p3b2,
        //         "p3b3" => $value->p3b3,
        //         "p3c" => $value->p3c,
        //         "p4a1" => $value->p4a1,
        //         "p4a2" => $value->p4a2,
        //         "p4a3" => $value->p4a3,
        //         "p4b" => $value->p4b,
        //         "p4c" => $value->p4c,
        //         "confirm" => $value->confirm,
        //         "total" => $value->total,
        //     ];

        //     MyPoint::where('id_student', $item->id_student)->where('id_dot', $item->id_dot)->update($arr_update);

        // }
        // return [
        //     "stt" => "success",
        // ];

        $id_student = $request->session()->get('account')->id_student;
        $student = Student::where('id_student', $id_student)->get()[0];
        $year = SchoolYear::all();
//        echo route('danh_sach_dot');
//        return;
        return view('client.point.add', ['year' => $year]);
    }

    function postAdd(Request $request)
    {


        $this->validate($request,
        [ 
            'begin' => 'required'
        ],
        [
            'begin.required' => 'Chưa nhập ngày'
        ]);

        $res = [
            "code" => 200,
            "message" => "OK",
            "callback" => route('danh_sach_dot'),
            "success" => [
              "1" => "Thêm vào thành công"
            ],
        ];

        $dxt = DotXetDiem::where('nam_hoc', $request->input('year'))
        ->where('hoc_ki', $request->input('semester'))->get();
        if (\count($dxt) > 0){
            return [
                "code" => 500,
                "message" => "OK",
                "success" => [
                  "1" => "Đã tồn tại đợt xét điểm."
                ],
            ];
        }

        $begin = Carbon::parse($request->input('begin'));
        $end = Carbon::parse($request->input('end'));
        if ($begin >= $end){
            return [
                "code" => 500,
                "message" => "OK",
                "success" => [
                  "1" => "Khoảng thời gian không hợp lệ."
                ],
            ];
        }

        $dot = new DotXetDiem;
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

            $temp_point = new MyPoint;
            $temp_point->id_dot = $dot->id_dot_xet;
            $temp_point->id_student = $value->id_student;
            $temp_point->confirm = 0;
            $temp_point->total = 0;
            $temp_point->save();
        }

        return $res;


    }

    public function danhSachDot(Request $request)
    {
        if (empty($request->input('page'))){
            $page = 1;
        } else{
            $page = $request->input('page');
        }

        $list = DotXetDiem::where('id_class', $request->session()->get('account')->id_class)->orderby('nam_hoc')->orderby('hoc_ki')->paginate(20);
        foreach ($list as $index  => $value){
            $list[$index]['xuat_sac'] = Point::where('id_dot', $value->id_dot_xet)->where('total', '>=', 90)->count('total');
            $list[$index]['gioi'] = Point::where('id_dot', $value->id_dot_xet)->where('total', '>=', 80)->where('total','<', 90)->count('total');
            $list[$index]['kha'] = Point::where('id_dot', $value->id_dot_xet)->where('total', '>=', 65)->where('total','<', 80)->count('total');
            $list[$index]['trung_binh'] = Point::where('id_dot', $value->id_dot_xet)->where('total', '>=', 50)->where('total','<', 65)->count('total');
            $list[$index]['yeu'] = Point::where('id_dot', $value->id_dot_xet)->where('total', '>=', 35)->where('total','<', 50)->count('total');
            $list[$index]['kem'] = Point::where('id_dot', $value->id_dot_xet)->where('confirm', 1)->where('total','<', 35)->count('total');
        }
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
        ->orderby('students.id_student')
        ->select('*')
        ->get();
        $dot = DotXetDiem::where('id_dot_xet', $id_dot)->get()->first();

        // return $students->tojson();

        return view('client.point.list_sinh_vien_dot',["students" => $students, 'id_dot' => $id_dot, 'dot' => $dot]);
    }

    public function delete(Request $request, $id_dot){

        $dot = DotXetDiem::find($id_dot);
        if (empty($dot)) return back();
        DotXetDiem::find($id_dot)->delete();
        return back();

    }

    public function downloadDotPDF(Request $request, $id_dot)
    {
        $dot = DotXetDiem::where('id_dot_xet', $id_dot)->get()->first();
        $students = Point::where('id_dot', $id_dot)
        ->join('students', 'students.id_student', '=', 'points.id_student')
        ->join('profiles', 'profiles.id_profile', '=', 'students.id_profile')
        ->orderby('students.id_student')
        ->select('students.*', 'points.total', 'points.note', 'profiles.first_name', 'profiles.last_name')
        ->get();
        // return $students;
        $list['xuat_sac'] = Point::where('id_dot', $id_dot)->where('total', '>=', 90)->count('total');
        $list['gioi'] = Point::where('id_dot', $id_dot)->where('total', '>=', 80)->where('total','<', 90)->count('total');
        $list['kha'] = Point::where('id_dot', $id_dot)->where('total', '>=', 65)->where('total','<', 80)->count('total');
        $list['trung_binh'] = Point::where('id_dot', $id_dot)->where('total', '>=', 50)->where('total','<', 65)->count('total');
        $list['yeu'] = Point::where('id_dot', $id_dot)->where('total', '>=', 35)->where('total','<', 50)->count('total');
        $list['kem'] = Point::where('id_dot', $id_dot)->where('confirm', 1)->where('total','<', 35)->count('total');
        $count = Point::where('id_dot', $id_dot)->where('confirm', 1)->count('total');
        // return view('client.point.download.thong_ke', 
        // [
        //     'dot' => $dot,
        //     'students' => $students,
        //     'count' => $count,
        //     'result' => $list,
        // ]);
        $pdf = PDF::loadView('client.point.download.thong_ke', 
        [
            'dot' => $dot,
            'students' => $students,
            'count' => $count,
            'result' => $list,
        ])->setPaper('a4');
        return $pdf->stream($dot->id_class."_".$dot->nam_hoc."_".$dot->hoc_ki.".pdf");
    }

    public function getNote(Request $request, $id_dot, $id_student)
    {
        $note = $request->input('note');
        Point::where('id_dot', $id_dot)->where('id_student', $id_student)->update(['note' => $note]);
        return $note;
    }

}
