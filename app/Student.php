<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    // protected $primaryKey = 'id_student';
    public $timestamps = false;

    public function profile()
    {
        return $this->hasOne('App\Profile', 'id_profile', 'id_profile');
    }

    public function classs()
    {
        return $this->hasOne('App\Classs', 'id_class', 'id_class');
    }

}
