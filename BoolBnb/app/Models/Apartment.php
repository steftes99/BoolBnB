<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = ['user_id', 'title', 'rooms', 'beds', 'bathrooms', 'square', 'city', 'country', 'region', 'address', 'lat', 'long', 'image', 'visible'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function stats(){
        return $this->hasMany('App\Models\Stat');
    }

    public function messages(){
        return $this->hasMany('App\Models\Message');
    }

    public function facilities(){
        return $this->belongsToMany('App\Models\Facility');
    }
    public function sponsorships(){
        return $this->belongsToMany('App\Models\Sponsorship');
    }
}

