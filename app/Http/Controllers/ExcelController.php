<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Student;

class ExcelController extends Controller implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        $students = Student::all();
        foreach ($students as $index => $value) {
            $student[] = array(
                '0' => $index + 1,
                '1' => $value->profile->first_name." ".$value->profile->last_name,
                '2' => $value->profile->email,
                '3' => $value->profile->phone_number,
                '4' => $value->profile->address,
            );
        }
        return (collect($student));
    }

    public function headings(): array
    {
        return [
            "STT",
            "Họ và tên",
            "Email",
            "SĐT",
            "Địa chỉ",
        ];
    }

    public function export()
    {
        return Excel::download(new ExcelController(), 'Student.xlsx');
    }

}
