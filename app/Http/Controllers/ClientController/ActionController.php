<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\ClientController\ClientController;
use Illuminate\Http\Request;
use App\Http\Requests\ActionsRequest;
use Validator;
use Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActionMail;

use Carbon\Carbon;
use App\Student;
use App\Action;
use App\Classs;
use App\Attendance;
use App\Category;
use App\ActionRelationshipClass;


class ActionController extends ClientController
{
    function getList(Request $request)
    {
        $id_class = $request->session()->get('account')->id_class;
        $actions = ActionRelationshipClass::where('id_class', $id_class)
        ->paginate(10);
        if ($request->input('type') == 'ajax') return view('client.action.ajax.actionList', ["actions" => $actions, 'page' => $request->input('page')]);
        return view('client.action.actionList', ["actions" => $actions]);
    }

    function getNewAction(Request $request)
    {
        $id_class = $request->session()->get('account')->id_class;
        $actions = ActionRelationshipClass::where('id_class', $id_class)->paginate(10);
        if ($request->input('type') == 'ajax') 
            return view('client.action.ajax.newActionList', ["actions" => $actions, 'page' => $request->input('page', 'default')]);
        return view('client.action.newActionList', ["actions" => $actions]);
    }

    function getAdd(Request $request)
    {
        $students = Student::join('profiles', 'profiles.id_profile', '=', 'students.id_profile')
            ->where('students.id_class', $request->session()->get('account')->id_class)
            ->select('students.*')
            ->orderby('profiles.last_name', 'asc')
            ->orderby('profiles.first_name', 'asc')->get();
        $categorys = Category::all();
        return view('client.action.add', ['students' => $students, 'categorys' => $categorys]);
    }

    function postAdd(Request $request)
    {
        // $validator = $request->validated();
        $this->validate($request,
        [
            'name' => 'required',
            'time' => 'required|date',
            'content' => 'required',
            'category' => 'required',
            'object' => 'required|numeric|min:0|max:2',
        ],
        [
            'name.required' => "Chưa nhập tên hoạt động.",
            'time.required' => "Chưa chọn thời gian.",
            'time.date' => "Chọn sai kiểu dữ liệu ngày giờ.",
            'category.required' => "Don't chossice category",
            'content.required' => "Chưa nhập nội dung.",
            'object.required' => "Chưa chọn đối tượng tham gia.",
            'object.numeric' => "Chọn sai đối tượng.",
            'object.min' => "Chọn sai đối tượng.",
            'object.max' => "Chọn sai đối tượng.",
        ]);

        $id_class = "18IT5";

        $action = new Action;
        $action->name = $request->input('name');
        $action->time = $request->input('time');
        $action->content = $request->input('content');
        $action->confirm = 0;
        $action->id_category = $request->input('category');

        $action->save();
        $ar = new ActionRelationshipClass;
        $ar->id_action = $action->id;
        $ar->id_class = $id_class;
        $ar->save();
        // $context = (object) [
        //     'name' => $request->input('name'),
        //     'time' => $request->input('time'),
        //     'fullname' => "Mai Văn Quang",
        //     'subject' => "Thông báo hoạt động mới",
        //     'link' => route('newActionDetail', ['id_action'=> $action->id]),
        // ];
        // Mail::to('mvquang.18it5@sict.udn.vn')->queue(new ActionMail($context));

        if ($request->input('object') == 0){
            $students = Student::join('class', 'students.id_class', '=', 'class.id_class')->where('class.id_class', $id_class)->select('students.*')->get();
            foreach ($students as $key => $value) {
                $AR = new Attendance;
                $AR->id_student = $value->id_student;
                $AR->id_action = $action->id;
                $AR->status = 0;
                $AR->point = 0;
                $AR->save();
            }
            Action::where('id_action', $action->id)->update(["type" => 0, 'sum' => count($students)]);
        }

        if ($request->input('object') == 1){
            $arr = $request->input('id_student');
            foreach ($arr as $key => $value) {
                $AR = new Attendance;
                $AR->id_student = $value;
                $AR->id_action = $action->id;
                $AR->status = 0;
                $AR->save();
            }
            Action::where('id_action', $action->id)->update(["type" => 1, 'sum' => \count($arr)]);
        }

        if ($request->input('object') == 2){
            Action::where('id_action', $action->id)->update(["type" => 2, 'sum' => 0]);
        }
        $res = [
            "code" => 200,
            "message" => "OK",
            "callback" => route('actionList'),
            "success" => [
              "1" => "Thêm vào thành công ".$action->name.".",
            ],
        ];
        return $res;
        // return redirect()->route('actionList')->with('notification', "Thêm thành công hoạt động ".$action->name.".");

    }

    function getDelete(Request $request, $id)
    {
        $action = Action::where('id_action', $id)->get();
        if (\count($action) < 1 ) return redirect()->route('actionList')->with('myErrors', "Hoạt động không tồn tại.");
        $action = $action[0];
        if ($action->confirm == 1) return \back()->with('myError', "Không thể xóa hoạt động ".$action->name.".");
        Action::where('id_action', $id)->delete();

        return redirect()->route('actionList')->with('notification', "Xóa thành công hoạt động ".$action->name.".");
    }

    function getMyAction(Request $request)
    {
        $id_student = $request->session()->get('account')->id_student;
        $actions = Action::join('attendance', 'action.id_action', '=', 'attendance.id_action')
        ->where('attendance.id_student', $id_student)
        ->select('action.*', 'attendance.status')
        ->orderby('created_at', 'desc')
        ->paginate(20);
        $categories = Category::all();
        if ($request->input('type') == 'ajax') 
        return view('client.action.ajax.myActionList', 
        [
            "actions" => $actions, 
            'page' => $request->input('page'),
            
        ]);
       
        return view('client.action.myActionList', 
        [
            'actions' => $actions,
            'categories' => $categories,
            'dataChart' => $this->dataChartStudent($id_student),
            'dataChartWithCategorys' => $this->dataChartStudentWithCategorys($id_student),
        ]);
    }

    function getNewActionDetail(Request $request, $id_action)
    {
        $action = Action::where('id_action', $id_action)->get();
        if (count($action) < 1) return redirect()->route('newActionList')
        ->with('myErrors', "Hoạt động không tồn tại.");
        $action = $action->first();
        if ($action->type == 2) {
            $id_student = $request->session()->get('account')->id_student;
            $ar = Attendance::where('id_action', $action->id_action)
            ->where('id_student', $id_student)
            ->get();
            $action['register'] = 0;
            if (count($ar)>0){
                $action['register'] = 1;
            }

        }
        return view('client.action.newActionDetail', ['action' => $action]);
    }

    function postRegisterAction(Request $request, $id_action)
    {
        $res = [
            "status" => 1,
        ];
        $action = Action::where('id_action', $id_action)->get();

        if (count($action) < 1){
            $res['status'] = 0;
            $res['err'] = "Hoọt động không tồn tại";
            return $res;
        }

        $action = $action->first();

        if ($action->type != 2){
            $res['status'] = 0;
            $res['err'] = "Không thể đăng ký hoặc hủy đăng ký hoạt động này";
            return $res;
        }
        $id_student = $request->session()->get('account')->id_student;
        $ar = Attendance::where('id_action', $action->id_action)
            ->where('id_student', $id_student)
            ->get();
        if (count($ar) < 1){
            $AR = new Attendance;
            $AR->id_student = $id_student;
            $AR->id_action = $action->id_action;
            $AR->status = 0;
            $AR->save();
            $res['message'] = "Hủy đăng ký";
            return $res;
        }

        Attendance::where('id_attendance', $ar->first()->id_attendance)->delete();
        $res['message'] = "Đăng ký";
        return $res;
    }

    public function getMyActionChart(Request $request)
    {
        $id_student = $request->session()->get('account')->id_student;
        $id_category = $request->input('category');
        $m = Attendance::where('id_student', $id_student)
        ->join('action', 'action.id_action', '=', 'attendance.id_action')
        ->where('action.id_category', $id_category)
        ->select('attendance.*')
        ->count();
        $n = Attendance::where('id_student', $id_student)
        ->join('action', 'action.id_action', '=', 'attendance.id_action')
        ->where('action.id_category', $id_category)
        ->select('attendance.*')
        ->where('attendance.status', 1)
        ->count();

        $data_detail['name'] = "Tham gia";
        $data_detail['y'] =  ($n == 0 )? 0  :($n/$m)*100;
        $data[] = $data_detail;
        $n = Attendance::where('id_student', $id_student)
        ->join('action', 'action.id_action', '=', 'attendance.id_action')
        ->where('action.id_category', $id_category)
        ->select('attendance.*')
        ->where('attendance.status', 0)
        ->count();
        $data_detail['name'] = "Không tham gia";
        $data_detail['y'] =  ($n == 0 )? 0  :($n/$m)*100;
        $data[] = $data_detail;
        return $data;
    }

    public function dataChartStudentWithCategorys($id_student)
    {
        $data = array();
        $categories = Category::all();
        $tmp[] = array();
        $sum = Attendance::where('id_student', $id_student)->where('status', 1)->count();
        foreach ($categories as $key => $category) {
            $data_detail['name'] = $category->name;
            $attendance = Attendance::where('id_student', $id_student)
                          ->join('action', 'action.id_action', '=', 'attendance.id_action')
                          ->where('action.id_category', $category->id_category)
                          ->select('attendance.*')
                          ->where('attendance.status', 1)->count();
            $data_detail['y'] = $attendance;
            $data[] = $data_detail;
        }
        return json_encode($data);
    }

    public function dataChartStudent($id_student)
    {
        $attendances = Attendance::where('id_student', $id_student);
        $m = count($attendances->get());
        $n = count($attendances->where('status', 1)->get());

        $data_detail['name'] = "Tham gia";
        $data_detail['y'] =  ($n == 0 )? 0  :($n/$m)*100;
        $data[] = $data_detail;
        $attendances = Attendance::where('id_student', $id_student);
        $n = count($attendances->where('status', 0)->get());
        $data_detail['name'] = "Không tham gia";
        $data_detail['y'] =  ($n == 0 )? 0  :($n/$m)*100;
        $data[] = $data_detail;
        return json_encode($data);

    }
    
}
