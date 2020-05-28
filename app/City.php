<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'state_id',
        'zip_id'
    ];
    
    
    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function zip()
    {
        return $this->belongsTo('App\Zip');
    }
}
