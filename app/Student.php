<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    public $timestamps = false;

    public function profile()
    {
        return $this->hasOne('App\Profile', 'id', 'id');
    }

    public function classs()
    {
        return $this->hasOne('App\Classs', 'id', 'id_class');
    }

}
