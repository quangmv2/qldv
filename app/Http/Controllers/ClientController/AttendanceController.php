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
        $actions = Action::where("id_class", $id_class)->paginate(20);
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
            Action::where('id_action', $id_action)->update(['confirm' => 1, 'join' => $action->sum]);
            ActionRelationship::where('id_action', $id_action)->update(['status' => 1]);
        }
        Action::where('id_action', $id_action)->update(['author' => $request->session()->get('account')->id_student]);
        $students = Student::join('action_relationship', 'students.id_student', '=', 'action_relationship.id_student')
        ->where('action_relationship.id_action', $id_action)
        ->select('students.*', 'action_relationship.status', 'action_relationship.note', 'students.id_profile')
        ->join('profiles', 'profiles.id_profile', '=', 'students.id_profile')
        // ->orderby('profiles.last_name', 'asc')
        // ->orderby('profiles.first_name', 'asc')
        ->orderby('students.id_student', 'asc')
        ->select('students.*', 'action_relationship.status', 'action_relationship.note')
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
        if ($status == 0) {
            $status = 1;
            $k=1;
        }
        else {
            $status = 0;
            $k=-1;
        }


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
        Action::where('id_action', $id_action)->update(['join' => $action->join + $k]);
        return;

    }

    public function postAttendanceNote(Request $request, $id_action, $id_student)
    {
        $AR = ActionRelationship::where('id_action', $id_action)->where('id_student', $id_student)->get();
        if (\count($AR) < 1){
            $res = [
                "status" => 0,
                "message" => "Không tìm thấy sinh viên hoặc hoạt động nào.",
            ];
            return $res;
        }

        $AR =$AR->first();

        $note = $request->input('note');
        ActionRelationship::where('id_action_relationship', $AR->id_action_relationship)->update(['note' => $note]);

        $res = [
            "status" => 1,
            "message" => "Lưu thành công.",
            "note" => $note,
        ];
        return $res;

    }

}
