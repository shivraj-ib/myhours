<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','active','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Get the teams user associated with.
     */
    public function teams()
    {
        return $this->belongsToMany('App\Team','user_team');
    }
    
    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }
}
