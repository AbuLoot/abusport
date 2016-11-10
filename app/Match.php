<?php

namespace App;

use Auth;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'matches';

    public function field()
    {
    	return $this->belongsTo('App\Field', 'field_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    public function chat()
    {
        return $this->hasMany('App\Chat');
    }

    public function getPriceForEachAttribute()
    {
        return ($this->price / $this->number_of_players) . 'тг';
    }

    public function getMatchUsersCountAttribute()
    {
        return $this->users->count() + 1;
    }

    public function getMatchDateAttribute()
    {
        list($date['year'], $date['month'], $date['day']) = explode('-', $this->date);

        return $date['day'].' '.trans('data.month.'.$date['month']).'. '.$date['year'];
    }
}
