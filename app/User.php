<?php

namespace App;

use App\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'surname', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function matches()
    {
        return $this->belongsToMany('App\Match', 'match_user', 'user_id', 'match_id');
    }

    public function friendsOfMine(){
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendsOf(){
        return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends(){
        return $this->friendsOfMine()->wherePivot('accepted', 1)->get()
            ->merge($this->friendsOf()->wherePivot('accepted', 1)->get());
    }

    public function friendRequest(){
        return $this->friendsOfMine()->wherePivot('accepted', 0)->get();
    }

    public function friendRequestPending(){
        return $this->friendsOf()->wherePivot('accepted', 0)->get();
    }

    public function hasFriendRequestPending(User $user){
        return $this->friendRequestPending()->where('id', $user->id)->count();
    }

    public function hasFriendRequestReceived(User $user){
        return $this->friendRequest()->where('id', $user->id)->count();
    }

    public function addFriend(User $user){
        return $this->friendsOf()->attach($user->id);
    }

    public function acceptedFriendRequest(User $user){
        return $this->friendRequest()->where('id', $user->id)->first()->pivot->update(['accepted' => 1]);
    }

    public function isFriendWith(User $user){
        return $this->friends()->where('id', $user->id)->count();
    }

}
