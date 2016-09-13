<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function districts()
    {
        return $this->hasMany('App\District');
    }
    
    public function profile()
    {
        return $this->hasMany('App\Profile');
    }
}
