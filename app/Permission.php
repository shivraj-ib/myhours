<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    /**
     * Get the roles assigned with permission.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role','role_permission');
    }
}
