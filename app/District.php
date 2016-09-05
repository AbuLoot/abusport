<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }
}
