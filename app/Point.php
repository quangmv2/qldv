<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = "points";
    protected $primaryKey = 'id_point';

    public function getStudent()
    {
        return $this->hasOne('App\Student', 'id_student', 'id_student');
    }

}
