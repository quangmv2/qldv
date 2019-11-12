<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ActionsRequest;
use Validator;

use Carbon\Carbon;
use App\Student;
use App\Action;
use App\Classs;
use App\ActionRelationship;


class ActionController extends Controller
{
    function getList(Request $request)
    {
        $id_class = $request->session()->get('account')->id_class;
        $actions = Action::where("id_class", $id_class)->orderby('created_at', 'desc')->paginate(20);
        if ($request->input('type') == 'ajax') return view('client.action.ajax.actionList', ["actions" => $actions, 'page' => $request->input('page', 'default')]);
        return view('client.action.actionList', ["actions" => $actions]);
    }

    function getNewAction(Request $request)
    {
        $id_class = $request->session()->get('account')->id_class;
        $actions = Action::where("id_class", $id_class)->orderby('created_at', 'desc')->paginate(20);
        if ($request->input('type') == 'ajax') return view('client.action.ajax.newActionList', ["actions" => $actions, 'page' => $request->input('page', 'default')]);
        return view('client.action.newActionList', ["actions" => $actions]);
    }

    function getAdd()
    {
        $students = Student::join('profiles', 'profiles.id_profile', '=', 'students.id_profile')->select('students.*')->orderby('profiles.last_name', 'asc')->orderby('profiles.first_name', 'asc')->get();
        return view('client.action.add', ['students' => $students]);
    }

    function postAdd(ActionsRequest $request)
    {
        
        $validator = $request->validated();
        $id_class = "18IT5";

        $action = new Action;
        $action->name = $request->input('name');
        $action->time = $request->input('time');
        $action->content = $request->input('content');
        $action->id_class = $id_class;
        $action->confirm = 0;
        $action->join = 0;

        $action->save();

        if ($request->input('object') == 0){
            $students = Student::join('class', 'students.id_class', '=', 'class.id_class')->where('class.id_class', $id_class)->select('students.*')->get();
            foreach ($students as $key => $value) {
                $AR = new ActionRelationship;
                $AR->id_student = $value->id_student;
                $AR->id_action = $action->id;
                $AR->status = 0;
                $AR->save();
            }
            Action::where('id_action', $action->id)->update(["type" => 0, 'sum' => count($students)]);
        }

        if ($request->input('object') == 1){
            $arr = $request->input('id_student');
            foreach ($arr as $key => $value) {
                $AR = new ActionRelationship;
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
        return redirect()->route('actionList')->with('notification', "Thêm thành công hoạt động ".$action->name.".");

    }

    function getDelete(Request $request, $id)
    {
        $action = Action::where('id_action', $id)->get();
        if (\count($action) < 1 ) return redirect()->route('actionList')->with('myErrors', "Hoạt động không tồn tại.");
        $action = $action[0];
        Action::where('id_action', $id)->delete();
        return redirect()->route('actionList')->with('notification', "Xóa thành công hoạt động ".$action->name.".");
    }
    
    function getMyAction(Request $request)
    {
        $id_student = $request->session()->get('account')->id_student;
        $actions = Action::join('action_relationship', 'action.id_action', '=', 'action_relationship.id_action')
        ->where('action_relationship.id_student', $id_student)
        ->select('action.*', 'action_relationship.status')
        ->orderby('created_at', 'desc')
        ->paginate(20);

        if ($request->input('type') == 'ajax') return view('client.action.ajax.myActionList', ["actions" => $actions, 'page' => $request->input('page', 'default')]);
        return view('client.action.myActionList', ['actions' => $actions]);
    }
    
    function getNewActionDetail(Request $request, $id_action)
    {
        $action = Action::where('id_action', $id_action)->get();
        if (count($action) < 1) return redirect()->route('newActionList')
        ->with('myErrors', "Hoạt động không tồn tại.");
        $action = $action[0];
        return view('client.action.newActionDetail', ['action' => $action]);
    }
}
