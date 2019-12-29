<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\ClientController\ClientController;
use Illuminate\Http\Request;

use App\Action;
use App\Attendance;
use App\Student;
use App\ActionRelationshipClass;

class AttendanceController extends ClientController
{
    function getList(Request $request)
    {
        $id_class = $request->session()->get('account')->id_class;
        $actions = ActionRelationshipClass::where('id_class', $id_class)
        ->join('action', 'action_relationship_class.id_action', '=', 'action.id_action')
        ->orderby('time', 'desc')->paginate(20);
        foreach ($actions as $key => $value) {
            
            $attendance = Attendance::where('id_action', $value->id_action)
                                ->join('students', 'students.id_student', '=', 'attendance.id_student')
                                ->where('students.id_class', $value->id_class)
                                ->select('attendance.*');
            $value['count'] =  $attendance->count();
            $value['join'] = $attendance->where('status', 1)->count();
        }
        if ($request->input('type') == 'ajax') return view('client.attendance.ajax.list', ["actions" => $actions, 'page' => $request->input('page', 'default')]);
        return view('client.attendance.list', ["actions" => $actions]);
    }

    function getAttendance(Request $request, $id_action)
    {
        $action = Action::where('id_action', $id_action)->get();
        if (count($action) < 1) return redirect()->route('attendanceList')
        ->with('myErrors', "Hoạt động không tồn tại.");
        $action = $action[0];
        if ($action->confirm == 0){
            Action::where('id_action', $id_action)->update(['confirm' => 1]);
            Attendance::where('id_action', $id_action)->update(['status' => 1, 'point' => 10]);
        }
        Action::where('id_action', $id_action)->update(['author' => $request->session()->get('account')->id_student]);
        $students = Student::join('attendance', 'students.id_student', '=', 'attendance.id_student')
        ->where('attendance.id_action', $id_action)
        ->select('students.*', 'attendance.status', 'attendance.note', 'students.id_profile')
        ->join('profiles', 'profiles.id_profile', '=', 'students.id_profile')
        // ->orderby('profiles.last_name', 'asc')
        // ->orderby('profiles.first_name', 'asc')
        ->orderby('students.id_student', 'asc')
        ->select('students.*', 'attendance.status', 'attendance.note', 'attendance.point')
        ->get();
        return view('client.attendance.attendance', ['students' => $students, 'action' => $action]);
    }

    function postApiAttendance(Request $request, $id_action, $id_student)
    {
        if (empty($id_action) && empty($id_student)) {
            $res = [
                "code" => 500,
                "message" => "Yêu cầu không hợp lệ. Vui lòng tải lại trang.",
            ];
            return json_encode($res);
        }
        $action = Action::where('id_action', $id_action)->get();
        if (count($action) < 1){
            $res = [
                "code" => 500,
                "message" => "Yêu cầu không hợp lệ. Vui lòng tải lại trang.",
            ];
            return json_encode($res);
        }

        $action = $action[0];
        if ($action->confirm == 0){
            $res = [
                "code" => 500,
                "message" => "Yêu cầu không hợp lệ. Vui lòng tải lại trang.",
            ];
            return json_encode($res);
        }

        $AR = Attendance::where('id_action', $id_action)->where('id_student', $id_student)->get();
        if (\count($AR) < 1){
            $res = [
                "code" => 500,
                "message" => "Yêu cầu không hợp lệ. Vui lòng tải lại trang.",
            ];
            return json_encode($res);
        }

        $AR = $AR[0];
        $point = 0;
        $status = $AR->status;
        if ($status == 0) {
            $status = 1;
            $point = 10;
        }
        else {
            $status = 0;
            $point = 0;
        }


        $res = [
            "code" => 200,
            "message" => "Finish.",
        ];
        if ($status == 0){
            $res["status"] = "Vắng";
            $res["class"] = "btn btn-danger";
            $res['point'] = 0;
        } else {
            $res["status"] = "Có mặt";
            $res["class"] = "btn btn-success";
            $res['point'] = 10;
        }

        echo json_encode($res);
        Attendance::where('id_action', $id_action)->where('id_student', $id_student)->update(['status' => $status, 'point' => $point]);
        return;

    }

    public function postAttendanceNote(Request $request, $id_action, $id_student)
    {
        $AR = Attendance::where('id_action', $id_action)->where('id_student', $id_student)->get();
        if (\count($AR) < 1){
            $res = [
                "status" => 0,
                "message" => "Không tìm thấy sinh viên hoặc hoạt động nào.",
            ];
            return $res;
        }

        $AR =$AR->first();

        $note = $request->input('note');
        Attendance::where('id_attendance', $AR->id_attendance)->update(['note' => $note]);

        $res = [
            "status" => 1,
            "message" => "Lưu thành công.",
            "note" => $note,
        ];
        return $res;

    }

    public function getPoint(Request $request, $id_action, $id_student)
    {
        $AR = Attendance::where('id_action', $id_action)->where('id_student', $id_student)->get();
        if (\count($AR) < 1){
            $res = [
                "status" => 0,
                "message" => "Không tìm thấy sinh viên hoặc hoạt động nào.",
            ];
            return $res;
        }

        $AR =$AR->first();
        if ($request->input('type') == "update") {
            if ($AR->status == 0 && $AR->point > 0)
            Attendance::where('id_attendance', $AR->id_attendance)->update(['point' => 0]); 
            return ['point' => Attendance::where('id_action', $id_action)->where('id_student', $id_student)->get()->first()->point];
        }
        $point = $request->input('point');
        Attendance::where('id_attendance', $AR->id_attendance)->update(['point' => $point]);

        $res = [
            "status" => 1,
            "message" => "Lưu thành công.",
            "point" => $point,
        ];
        return $res;
    }

}
