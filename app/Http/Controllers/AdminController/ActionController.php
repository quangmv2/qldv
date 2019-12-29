<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $action->confirm = 0;
        $action->id_category = $request->input('category');
        $action->join = 0;

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

}
