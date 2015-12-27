<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    public function notifications()
    {
        return $this->hasMany('App\Notifications');
    }
}
