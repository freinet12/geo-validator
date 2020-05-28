<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zip extends Model
{
    protected $fillable = [
        'zip_code',
        'state_id'
    ];
    
    
    public function state()
    {
        return $this->belongsTo('App\Zip');
    }

    public function cities()
    {
        return $this->hasMany('App\Cities');
    }
}
