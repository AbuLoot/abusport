<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';

    public function organization()
    {
        return $this->belongsTo('App\Organization', 'org_id');
    }

    public function sport()
    {
    	return $this->belongsTo('App\Sport', 'sport_id');
    }

    public function fields()
    {
        return $this->hasMany('App\Field');
    }

    public function getFieldsMatchesCountAttribute()
    {
        $matches = 0;
        // ->where('date', '>=', date('Y-m-d'))
        foreach ($this->fields as $field)
        {
            $matches += $field->matches->count();
        }

        return $matches;
    }
}