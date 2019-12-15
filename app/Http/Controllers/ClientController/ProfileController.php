<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\ClientController\ClientController;
use Illuminate\Http\Request;

use App\Student;
use App\Profile;

class ProfileController extends ClientController
{
    public function index(Request $request)
    {
        $phone_number = $request->input('phone_number');
        $address = $request->input('address');

        $id_student = $request->session()->get('account')->id_student;
        $student = Student::where('id_student', $id_student)->get()->first();
        Profile::where('id_profile', $student->id_profile)
        ->update([
            'phone_number' => $phone_number,
            'address' => $address,
        ]);
        return [
            'message' => 'Cập nhật thành công',
        ];
    }
    public function getProfile(Request $request)
    {
        $id_student = $request->session()->get('account')->id_student;
        $student = Student::where('id_student', $id_student)->get()->first();
        return [
            "name" => $student->profile->first_name." ".$student->profile->last_name,
            "email" => $student->profile->email,
            "class" => $student->classs->id_class." (".explode('-', $student->classs->start_study)[0]."-".explode('-', $student->classs->end_study)[0].") - ".$student->position->name,
            "birthday" => $student->profile->birthday,
            "phone_number" => $student->profile->phone_number,
            "address" => $student->profile->address,
        ];
    }
}
