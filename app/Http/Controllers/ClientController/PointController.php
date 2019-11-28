<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use Carbon\Carbon;

use App\Classs;
use App\Student;
use App\DotXetDiem;
use App\SchoolYear;
use App\Point;
use App\TempPoint;

class PointController extends Controller
{

    function getDanhGia(Request $request, $id_dot, $name, $id_student){

        $dot = DotXetDiem::where('id_dot_xet', $id_dot)->get()->first();
        if (empty($dot)){
            return redirect()->route('danh_sach_dot')->with('myErrors', "Đợt xét điểm không tồn tại");
        }

        $student = Student::where('id_student', $id_student)->get()->first();
        if (empty($student)){
            return redirect()->route('getDot', ['id_dot' => $id_dot])->with('myErrors', "Sinh viên không tồn tại");
        }

        $client = new Client();
        $res = $client->request('GET', 'http://diemrenluyen.xyz/point/'.$id_student);
        $content = (object) $res->getBody();
        $json = json_decode($content->getContents(), true);

        $point_study = $json['point'];

        $my_point = Point::where('id_dot', $id_dot)
        ->where('id_student', $id_student)
        ->get()->first();

        if ($my_point->confirm == 0){

            $arr_update = [
                "p1a" => 0,
                "p1b1" => 0,
                "p1b2" => 0,
                "p1c" => 0,
                "p1d" => 0,
                "p1dd" => convertPointToPoint($point_study),
                "p2a1" => 0,
                "p2a2" => 0,
                "p2b1" => 0,
                "p2b2" => 0,
                "p2b3" => 0,
                "p3a1" => 0,
                "p3a2" => 0,
                "p3b1" => 0,
                "p3b2" => 0,
                "p3b3" => 0,
                "p3c" => 0,
                "p4a1" => 0,
                "p4a2" => 0,
                "p4a3" => 0,
                "p4b" => 0,
                "p4c" => 0,
                "confirm" => 1,
            ];
            Point::where('id_dot', $id_dot)
            ->where('id_student', $id_student)
            ->update($arr_update);
            updateTotal($my_point->id_point);

        }


        $my_point = Point::where('id_dot', $id_dot)
        ->where('id_student', $id_student)
        ->get()->first();

        $my_temp_point = TempPoint::where('id_dot', $id_dot)
        ->where('id_student', $id_student)
        ->get()->first();

        if (empty($my_point) || empty($my_temp_point)) return view('errors.404');

        return view('client.point.danh_gia', ['my_point' => $my_point, 'my_temp_point' => $my_temp_point]);

    }

    function postDanhGia(Request $request, $id_dot, $name, $id_student){

        $input = $request->all();



        $res = [
            "code" => 200,
            "message" => "Finish",
            "data" => $input,
        ];

        return $res;

    }

}
