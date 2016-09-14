<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    protected $table = 'friends';
    
    protected $fillable = [
        'id', 'friend1_id', 'friend2_id', 'friend_check_1', 'friend_check_2',
    ];
}
