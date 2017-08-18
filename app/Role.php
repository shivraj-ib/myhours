<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    protected $touches = ['permissions'];
    
    /**
     * Get the permissions for the role.
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission','role_permission');
    }
    
    /**
     * Get user's by role
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
