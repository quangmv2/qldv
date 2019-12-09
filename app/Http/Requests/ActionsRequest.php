<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ActionsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'time' => 'required|date',
            'content' => 'required',
            'object' => 'required|numeric|min:0|max:2',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Chưa nhập tên hoạt động.",
            'time.required' => "Chưa chọn thời gian.",
            'time.date' => "Chọn sai kiểu dữ liệu ngày giờ.",
            'content.required' => "Chưa nhập nội dung.",
            'object.required' => "Chưa chọn đối tượng tham gia.",
            'object.numeric' => "Chọn sai đối tượng.",
            'object.min' => "Chọn sai đối tượng.",
            'object.max' => "Chọn sai đối tượng.",
        ];
    }
}
