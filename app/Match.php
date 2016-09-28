<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'matches';

    public function Field()
    {
    	return $this->belongsTo('App\Field', 'field_id');
    }

    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    public function getPriceForEachAttribute()
    {
    	return ($this->price / $this->number_of_players) . 'тг';
    }
}
