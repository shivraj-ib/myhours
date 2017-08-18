<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    /**
     * Get the users assigned with team.
     */
    public function users()
    {
        return $this->belongsToMany('App\User','user_team');
    }
}
