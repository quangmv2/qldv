<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\DotXetDiem;
use App\Point;
use App\TempPoint;

class MyPointController extends Controller
{
    public function getList(Request $request)
    {
        $list = DotXetDiem::where('id_class', $request->session()->get('account')->id_class)
        ->join('points', 'points.id_dot', '=' , 'dot_xet_diem.id_dot_xet')
        ->where('id_student', $request->session()->get('account')->id_student)
        ->get();
        return view('client.my_point.danh_sach_dot', ['list' => $list]);
    }

    public function getDot(Request $request, $id_dot)
    {
        $my_point = Point::where('id_dot', $id_dot)
        ->where('id_student', $request->session()->get('account')->id_student)
        ->get()->first();

        $my_temp_point = TempPoint::where('id_dot', $id_dot)
        ->where('id_student', $request->session()->get('account')->id_student)
        ->get()->first();

        return view('client.my_point.tu_danh_gia', ['my_point' => $my_point, 'my_temp_point' => $my_temp_point]);
    }

}
