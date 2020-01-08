<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Action;
use App\Attendance;
use App\Category;
use App\Classs;
use App\ActionRelationshipClass;
use App\Student;

class ActionController extends Controller
{
    public function getList(Request $request)
    {
        // $actions = ActionRelationshipClass::groupby('id_action')
        // ->select('action_relationship_class.id_action', DB::raw('count(*) as count'))
        // ->having('count', '>', 1)
        // ->get();
        // $actions = Action::where('author', 1)
        // ->orderby('time', 'desc')
        // ->paginate(20);
        $type = $request->input('type');
        $category = $request->input('category');
        $page = $request->input('page');
        $dau = '=';
        if (empty($category) || $category == 'all') {
            $category = 0;
            $dau = '>';
        }
        $categories = Category::where('id_category', $dau, $category)->orderby('name')->get();
        $actions = ActionRelationshipClass::join('action', 'action_relationship_class.id_action', '=', 'action.id_action')
        ->where('action.id_category', $dau, $category)
        ->where('action.author', 1)
        ->orderby('time', 'desc')
        ->groupby('action_relationship_class.id_action')
        ->select('action_relationship_class.id_action')
        ->paginate(50);
        foreach ($actions as $key => $value) {
            
            $attendance = Attendance::where('id_action', $value->id_action)
                                ->join('students', 'students.id_student', '=', 'attendance.id_student')
                                ->where('students.id_class', $value->id_class)
                                ->select('attendance.*');
            $value['count'] =  $attendance->count();
            $value['join'] = $attendance->where('status', 1)->count();
        }
        switch ($type) {
            case 'ajaxCategory':
                return view('admin.action.ajax.list', ['actions' => $actions, 'page' => $page]);
                break;
            
            default:
                if (empty($page)) return view('admin.action.list', ['actions' => $actions, 'categories' => $categories]);
                return view('admin.action.ajax.list', ['actions' => $actions, 'page' => $page]);
                break;
        }
        
        
    }

    public function getAdd(Request $request)
    {
        $students = Student::join('profiles', 'profiles.id_profile', '=', 'students.id_profile')
            ->select('students.*')
            ->orderby('profiles.last_name', 'asc')
            ->orderby('profiles.first_name', 'asc')->get();
        $categorys = Category::all();
        $class = Classs::all();
        return view('admin.action.add', ['students' => $students, 'categorys' => $categorys, 'class' => $class]);
    }
    
    public function postAdd(Request $request)
    {
        // return $request->all();
        // $this->validate($request,
        // [
        //     'name' => 'required',
        //     'time' => 'required|date',
        //     'content' => 'required',
        //     'category' => 'required',
        //     'object' => 'required|numeric|min:0|max:2',
        // ],
        // [
        //     'name.required' => "Chưa nhập tên hoạt động.",
        //     'time.required' => "Chưa chọn thời gian.",
        //     'time.date' => "Chọn sai kiểu dữ liệu ngày giờ.",
        //     'category.required' => "Don't chossice category",
        //     'content.required' => "Chưa nhập nội dung.",
        //     'object.required' => "Chưa chọn đối tượng tham gia.",
        //     'object.numeric' => "Chọn sai đối tượng.",
        //     'object.min' => "Chọn sai đối tượng.",
        //     'object.max' => "Chọn sai đối tượng.",
        // ]);


        $action = new Action;
        $action->name = $request->input('name');
        $action->time = $request->input('time');
        $action->content = $request->input('content');
        $action->id_category = $request->input('category');
        $action->author = '1';

        $action->save();

        // $context = (object) [
        //     'name' => $request->input('name'),
        //     'time' => $request->input('time'),
        //     'fullname' => "Mai Văn Quang",
        //     'subject' => "Thông báo hoạt động mới",
        //     'link' => route('newActionDetail', ['id_action'=> $action->id]),
        // ];
        // Mail::to('mvquang.18it5@sict.udn.vn')->queue(new ActionMail($context));

        $classs = $request->input('id_class');
        foreach ($classs as $key => $id_classs) {
            $students = Student::join('class', 'students.id_class', '=', 'class.id_class')->where('class.id_class', $id_classs)->select('students.*')->get();
            $ar = new ActionRelationshipClass;
            $ar->id_action = $action->id;
            $ar->id_class = $id_classs;
            $ar->save();
            foreach ($students as $key => $value) {
                $AR = new Attendance;
                $AR->id_student = $value->id_student;
                $AR->id_action = $action->id;
                $AR->status = 0;
                $AR->point = 0;
                $AR->save();
            }
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

    public function getListCategory(Request $request)
    {
        $categories = Category::all();
        return view('admin.action.category.list', ['categories' => $categories]);
    }

    public function getAddCategory(Request $request)
    {
        return view('admin.action.category.add');
    }

    public function postAddCategory(Request $request)
    {
        $name = $request->input('name');
        $category = new Category;
        $category->name = $name;
        $category->save();
        return redirect()->back();
    }

    public function getDeleteCategory(Request $request, $id)
    {
        Category::find($id)->delete();
        return redirect()->back();
    }

    public function getChartList(Request $request, $id_action)
    {
        $type = $request->input('type');

        $data = [];
        $actions = ActionRelationshipClass::where('id_action', $id_action)->orderby('id_class')->get();
        foreach ($actions as $key => $action) {
            $tmp = [];
            $attendances = Attendance::where('id_action', $action->id_action)
            ->join('students', 'students.id_student', '=', 'attendance.id_student')
            ->where('students.id_class', $action->id_class)
            ->select('attendance.*')
            ->get();
            $sum = 0;
            $count = 0;
            foreach ($attendances as $key => $attendance) {
                if ($attendance->status == 1) $count-=-1;
                $sum-=-1;
            }
            $data_detail['name'] = "Tham gia";
            $data_detail['count'] = $count;
            $data_detail['y'] = (float) ($count/$sum)*100;
            $tmp[] = $data_detail;
            $data_detail['name'] = "Không ham gia";
            $data_detail['count'] = $sum - $count;
            $data_detail['y'] = (float) (($sum - $count)/$sum)*100;
            $tmp[] = $data_detail;

            $detail = [
                "data" => $tmp,
                "id_class" => $action->id_class,
                "name" => $action->getAction->name,
                "id_action" => $action->id_action,
            ];

            $data[] = $detail;

        }
        // return $data;
        switch ($type) {
            case 'chart':
                return view('admin.action.ajax.thong_ke_action', ['data' => $data]);
                break;
            case 'table':
                return view('admin.action.ajax.thong_ke_action_table', ['data' => $data]);
            default:
                return $data;
                break;
        }
        
    }

    public function getChartActionClass(Request $request, $id_action, $id_class)
    {
        $students = Student::where('id_class', $id_class)
        ->join('attendance', 'attendance.id_student', '=', 'students.id_student')
        ->where('attendance.id_action', $id_action)
        ->orderby('students.id_student')
        ->join('profiles', 'profiles.id_profile', '=', 'students.id_profile')
        ->select('profiles.first_name', 'profiles.last_name', 'attendance.status', 'attendance.note', 'students.id_student')
        ->get();
        return $students;
    }

    public function getChartCategory(Request $request)
    {
        $category = $request->input('category');
        $dau = '=';
        if (empty($category) || $category=='all'){
            $category = -1;
            $dau = '>';
        }

    }

}
