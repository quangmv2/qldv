<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DotXetDiem extends Model
{
    protected $table = 'dot_xet_diem';
    protected $primaryKey = 'id_dot_xet';

    public function find_class()
    {
        return $this->belongsTo('App\Classs', 'id_class', 'id_class');
    }

}
