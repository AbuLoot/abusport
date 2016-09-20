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

    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }

    public function todaySchedule()
    {
        return $this->schedules()->where('week', date('w'))->get();
    }

    public function options()
    {
        return $this->belongsToMany('App\Option', 'field_option', 'field_id', 'option_id');
    }
}
