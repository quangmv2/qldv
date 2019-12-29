<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionRelationshipClass extends Model
{
    protected $table = 'action_relationship_class';
    public $timestamps = false;

    public function getAction()
    {
        return $this->belongsTo('App\Action', 'id_action', 'id_action');
    }
}
