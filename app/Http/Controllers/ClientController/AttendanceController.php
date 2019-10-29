<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Action;
use App\ActionRelationship;
use App\Student;

class AttendanceController extends Controller
{
    function getList(Request $request)
    {
        $id_class = $request->session()->get('account')->id_class;
        $actions = Action::where("id_class", $id_class)->paginate(15);
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
            ActionRelationship::where('id_action', $id_action)->update(['status' => 1]);
        }
        Action::where('id_action', $id_action)->update(['author' => $request->session()->get('account')->id_student]);
        $students = Student::join('action_relationship', 'students.id_student', '=', 'action_relationship.id_student')
        ->where('action_relationship.id_action', $id_action)->select('students.*', 'action_relationship.status')->get();
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

        $AR = ActionRelationship::where('id_action', $id_action)->where('id_student', $id_student)->get();
        if (\count($AR) < 1){
            $res = [
                "code" => 500,
                "message" => "Yêu cầu không hợp lệ. Vui lòng tải lại trang.",
            ];
            return json_encode($res);
        }

        $AR = $AR[0];

        $status = $AR->status;
        if ($status == 0) $status = 1;
        else $status = 0;


        $res = [
            "code" => 200,
            "message" => "Finish.",
        ];
        if ($status == 0){
            $res["status"] = "Vắng";
            $res["class"] = "btn btn-danger";
        } else {
            $res["status"] = "Có mặt";
            $res["class"] = "btn btn-success";
        }

        echo json_encode($res);
        ActionRelationship::where('id_action', $id_action)->where('id_student', $id_student)->update(['status' => $status]);
        return;

    }

}
