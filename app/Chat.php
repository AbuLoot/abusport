<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';

    protected $fillable = [
    	'user_id', 'match_id', 'message'
    ];

    public function match()
    {
        return $this->belongsTo('App\Match', 'match_id');
    }
}
