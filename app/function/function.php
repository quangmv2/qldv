<?php

use App\User;

function utf8convert($str) {

    if(!$str) return false;

    $utf8 = [

            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'd'=>'đ|Đ',

            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',

            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ'];

    foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);

    return $str;

}

function utf8tourl($text) {
    $text = strtolower(utf8convert($text));
    // echo $text;
    // die();
    // $text = str_replace( "ß", "ss", $text);
    // $text = str_replace( "%", "", $text);
    // $text = preg_replace("/[^_a-zA-Z0-9 -] /", "",$text);
    // $text = str_replace(array('%20', ' '), '-', $text);
    // $text = str_replace("----","-",$text);
    // $text = str_replace("---","-",$text);
    // $text = str_replace("--","-",$text);
    $str = "";
    // echo $text;
    // die();
    for ($i = 0; $i < strlen($text); $i++) {
        $k = ord($text[$i]);
        if (($k<=122 && $k>=97) || ($text[$i] == " ")) {
            $str .=$text[$i];
        }else{

        }
    }
    return $str;
}

function createEmailStudent($text, $class)
{
    $text = utf8tourl($text);
    $k = explode(' ', $text);
    $name = "";
    $class = strtolower($class);
    for ($i=0; $i < count($k) - 1; $i++) { 
        $name .= $k[$i][0];
    }
    $name.=$k[count($k) - 1];

    $user = User::where('email', 'like', $name."%".".".$class."%")->get();
    if (!count($user)>0) return $name.".".$class."@sict.udn.vn";
    

    $email1 = $user[count($user) - 1]->email;

    $name1 = explode('@', $email1);

    if ($name1 == $name) return $name."1.".$class."@sict.udn.vn";
    $number = (int)$name1[count($name1) - 1];

    return $name.($number + 1).".".$class."@sict.udn.vn";
}


?>