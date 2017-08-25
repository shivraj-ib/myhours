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
    
    public function setPermNameAttribute($value)
    {
        $this->attributes['perm_name'] = $value;
        $this->attributes['perm_slug'] = strtolower(preg_replace('/\s+/', '_', $value));
    }
}
