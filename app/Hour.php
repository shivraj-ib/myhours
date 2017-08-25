<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Hour extends Model
{

   public function setContentAttribute($value)
    {
        $this->attributes['content'] = trim($value);
    }
    
    public function setActivityDateAttribute($value)
    {
        $this->attributes['activity_date'] = Carbon::createFromFormat("d-m-Y", $value)->toDateTimeString();
    }
    
    public function setTimeAttribute($value)
    {
        $this->attributes['time'] = number_format($value,2);
    }
    
    public function getActivityDateAttribute($value)
    {
         return date_format(date_create($value),"d-m-Y");
    }

}
