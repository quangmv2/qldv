<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classs extends Model
{
    protected $table = 'class';
    public $timestamps = false;

    public function teachers()
    {
        return $this->hasOne('App\Teacher', 'id_teacher', 'id_teacher');
    }

}
