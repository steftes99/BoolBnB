<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $fillable = ['price', 'hour_duration'];
    
    public function apartments(){
        return $this->belongsToMany('App\Models\Apartment')->withPivot('start_date', 'end_date');
    }
}
