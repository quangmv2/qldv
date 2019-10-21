<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    public $timestamps = false;

    public function profile()
    {
        return $this->hasOne('App\Profile', 'id_profile', 'id_profile');
    }

}
