<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organizations';

    public function areas()
    {
    	return $this->hasMany('App\Area');
    }

    public function org_type()
    {
    	return $this->belongsTo('App\OrgType', 'org_type_id');
    }
}
