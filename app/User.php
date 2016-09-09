<?php

namespace App;

use App\HasRole;

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

    public $userProfile = null;

    public function getUserProfile() {
        if($this->userProfile == null) {
            $this->userProfile = Profile::join('users', 'users.id', '=', 'profiles.user_id')
                ->where('profiles.user_id', '=', $this->id)
                ->get();
        }

        return $this->userProfile;
    }

    public $userCity = null;

    public function getUserCity() {
        if($this->userCity == null) {
            $this->userCity = City::join('profiles', 'profiles.city_id', '=', 'cities.id')
                ->where('profiles.user_id', '=', $this->id)
                ->orderBy('cities.sort_id')
                ->get(['cities.*', 'profiles.user_id']);
        }

        return $this->userCity;
    }

}
