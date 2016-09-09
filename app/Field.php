<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'fields';

    public function area()
    {
    	return $this->belongsTo('App\Area', 'area_id');
    }
}
