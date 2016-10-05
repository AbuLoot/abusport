<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    public function field()
    {
    	return $this->belongsTo('App\Field', 'field_id');
    }
}
