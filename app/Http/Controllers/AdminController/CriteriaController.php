<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Criteria;

class CriteriaController extends Controller
{
    function getAdd()
    {
        $criterias = Criteria::all();
        return view('admin.criteria.add', ['criterias' => $criterias]);
    }

    function postAdd(Request $request)
    {
        $criteria = new Criteria;
        $criteria->title = $request->input('title');
        $criteria->id_criteria_relationship = $request->input('id_criteria_relationship');
        $criteria->point = $request->input('point');
        $criteria->save();
        return back()->with('notification', "Thêm thành công tiêu chí ".$criteria->title.",");
     
    }
}
