<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
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
use App\DotRelationship;

class DotXetDiemController extends Controller
{

    public function getList(Request $request)
    {
        $type = $request->input('type');
        $page = $request->input('page');
        if (empty($type) || $type == null) {
            return view('admin.point.list');
        } 
        switch ($type) {
            case 'dot':
                return view('admin.point.ajax.listForDot', ['dots' => $this->getListDots()]);
                break;
            case 'class':
                return view('admin.point.ajax.listForClass', ['classs' => $this->getListClasss()]);
                break;
            default:
                abort('404');
                break;
        }
    }

    public function getListClasss()
    {
        $classs = Classs::orderby('id_class')->get();
        return $classs;
    }

    public function getListDots()
    {
        $dots = DotXetDiem::orderby('id_dot_xet')->orderby('hoc_ki')->get();
        return $dots;
    }

    public function getForClass(Request $request, $class)
    {

        $list = DotXetDiem::join('dot_xet_diem_rela_class', 'dot_xet_diem_rela_class.id_dot', '=', 'dot_xet_diem.id_dot_xet')
        ->where('id_class', $class)->orderby('nam_hoc')->select('dot_xet_diem.*')->orderby('hoc_ki')->get();
        foreach ($list as $index  => $value){
            $list[$index]['xuat_sac'] = Point::where('id_dot', $value->id_dot_xet)->where('total', '>=', 90)->count('total');
            $list[$index]['gioi'] = Point::where('id_dot', $value->id_dot_xet)->where('total', '>=', 80)->where('total','<', 90)->count('total');
            $list[$index]['kha'] = Point::where('id_dot', $value->id_dot_xet)->where('total', '>=', 65)->where('total','<', 80)->count('total');
            $list[$index]['trung_binh'] = Point::where('id_dot', $value->id_dot_xet)->where('total', '>=', 50)->where('total','<', 65)->count('total');
            $list[$index]['yeu'] = Point::where('id_dot', $value->id_dot_xet)->where('total', '>=', 35)->where('total','<', 50)->count('total');
            $list[$index]['kem'] = Point::where('id_dot', $value->id_dot_xet)->where('confirm', 1)->where('total','<', 35)->count('total');
        }
        return view('admin.point.class.class', ['list' => $list, 'id_class' => $class]);
    }

    public function getDot(Request $request, $id_class, $id_dot)
    {
        if ($id_dot == -1) {
            $dot = DotXetDiem::join('dot_xet_diem_rela_class', 'dot_xet_diem_rela_class.id_dot', '=', 'dot_xet_diem.id_dot_xet')
            ->where('id_class', $id_class)
            ->where('nam_hoc', $request->input('nam_hoc'))
            ->where('hoc_ki', $request->input('hoc_ki'))
            ->get()->first();
            if (empty($dot)) return abort('404');
            return redirect()->route('getDotAD', ['id_dot'=>$dot->id_dot_xet, 'id_class' => $id_class]);
        }

        $students = Point::where('id_dot', $id_dot)
        ->join('students', 'students.id_student', '=', 'points.id_student')
        ->join('profiles', 'profiles.id_profile', '=', 'students.id_profile')
        ->where('students.id_class', $id_class)
        ->orderby('students.id_student')
        ->select('*')
        ->get();
        $dot = DotXetDiem::where('id_dot_xet', $id_dot)->get()->first();
        
        if (empty($dot)) return abort('404');
        // return $students->tojson();

        return view('admin.point.list_sinh_vien',["students" => $students, 'id_dot' => $id_dot, 'dot' => $dot]);
    }
   
    public function getForDot(Request $request, $id_dot)
    {
        # code...
    }

    function getAdd(Request $request)
    {
        $id_student = $request->session()->get('account')->id_student;
        $student = Student::where('id_student', $id_student)->get()[0];
        $year = SchoolYear::all();
        return view('admin.point.add', ['year' => $year]);
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
        $dot->save();

        $year = $request->input('year');
        $year = explode('-', $year);
        $year[0] = (int) $year[0];
        $year[1] = (int) $year[1];
        $classs = Classs::all();
        foreach ($classs as $key => $class) {
            $begin = (int) explode('-', $class->start_study)[0];
            $end = (int) explode('-', $class->end_study)[0];
            if ($year[0] >= $begin && $year[1] <= $end ){
                $dot_re = new DotRelationship;
                $dot_re->id_class = $class->id_class;
                $dot_re->id_dot = $dot->id_dot_xet;
                $dot_re->save();
            }

            $students = Student::join('class', 'class.id_class', '=', 'students.id_class')
            ->where('class.id_class', $class->id_class)
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
        }

        

        return $res;
    }

    public function getThongke(Request $request)
    {
        $years = SchoolYear::orderby('id_year')->get();
        $classs = Classs::orderby('id_class')->get();
        return view('admin.thongke.thongke', ['years'=>$years, 'classs'=>$classs]);
    }

    public function getThongKeAJAX(Request $request)
    {
        $dau_nam = $request->input('nam_hoc') == 'all' ? '!=' : '=';
        $nam_hoc = $request->input('nam_hoc') == 'all' ? '0' : $request->input('nam_hoc');
        $hoc_ki = $request->input('hoc_ki');
        $dau_lop = $request->input('lop') == 'all' ? '!=' : '=';
        $lop = $request->input('lop') == 'all' ? '0' : $request->input('lop');


        $data = [];

        $years = SchoolYear::where('id_year', $dau_nam, $nam_hoc)->orderby('id_year')->get();

        $classs = Classs::where('id_class', $dau_lop, $lop)->get();
        foreach ($classs as $key => $class) {
            
            foreach ($years as $key => $year) {
                if ($hoc_ki == 'all'){
                    for ($i=1; $i <= 2; $i++) { 
                        $data_detail = $this->danhSachDotChart($year->id_year, $i, $class->id_class);
                        $data[] = $data_detail;
                    }
                    continue;
                }
                $data_detail = $this->danhSachDotChart($year->id_year, $hoc_ki, $class->id_class);
                $data[] = $data_detail;
            }

        }
        return view('admin.thongke.ajax.thongke',
        [
            'classs' => $classs,
            'hoc_ki' => $hoc_ki,
            'years' => $years,
            'data' => $data,
        ]);
    }

    public function danhSachDotChart($nam_hoc, $hoc_ki, $lop)
    {
        $list = DotXetDiem::join('dot_xet_diem_rela_class', 'dot_xet_diem_rela_class.id_dot', '=', 'dot_xet_diem.id_dot_xet')
        ->where('id_class', $lop)
        ->where('nam_hoc', $nam_hoc)
        ->where('hoc_ki', $hoc_ki)
        ->get();
        if (count($list) < 1) return [];
        $list = $list->first();
        
        $count = Point::where('id_dot', $list->id_dot_xet)->count('total');
        $list['xuat_sac'] = Point::where('id_dot', $list->id_dot_xet)->where('total', '>=', 90)->count('total');
        $list['gioi'] = Point::where('id_dot', $list->id_dot_xet)->where('total', '>=', 80)->where('total','<', 90)->count('total');
        $list['kha'] = Point::where('id_dot', $list->id_dot_xet)->where('total', '>=', 65)->where('total','<', 80)->count('total');
        $list['trung_binh'] = Point::where('id_dot', $list->id_dot_xet)->where('total', '>=', 50)->where('total','<', 65)->count('total');
        $list['yeu'] = Point::where('id_dot', $list->id_dot_xet)->where('total', '>=', 35)->where('total','<', 50)->count('total');
        $list['kem'] = Point::where('id_dot', $list->id_dot_xet)->where('confirm', 1)->where('total','<', 35)->count('total');

        $data = [];
        $data_detail['name'] = "Xuất sắc";
        $data_detail['y'] = $list['xuat_sac'] == 0 ? 0 : ($list['xuat_sac']/$count)*100;
        $data[] = $data_detail;

        $data_detail['name'] = "Giỏi";
        $data_detail['y'] = $list['gioi'] == 0 ? 0 : ($list['gioi']/$count)*100;
        $data[] = $data_detail;

        $data_detail['name'] = "Khá";
        $data_detail['y'] = $list['kha'] == 0 ? 0 : ($list['kha']/$count)*100;
        $data[] = $data_detail;

        $data_detail['name'] = "Trung bình";
        $data_detail['y'] = $list['trung_binh'] == 0 ? 0 : ($list['trung_binh']/$count)*100;
        $data[] = $data_detail;

        $data_detail['name'] = "Yếu";
        $data_detail['y'] = $list['yeu'] == 0 ? 0 : ($list['yeu']/$count)*100;
        $data[] = $data_detail;

        $data_detail['name'] = "Kém";
        $data_detail['y'] = $list['kem'] == 0 ? 0 : ($list['kem']/$count)*100;
        $data[] = $data_detail;

        return $data;

    }




}
