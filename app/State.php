<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    
    protected $fillable = [
        'name'
    ];

    public function cities()
    {
        return $this->hasMany('App\City');
    }

    public function zips()
    {
        return $this->hasMany('App\Zips');
    }
}
