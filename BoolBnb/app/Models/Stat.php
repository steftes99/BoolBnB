<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = ['apartment_id', 'ip', 'date'];

    public function apartment(){
        return $this->belongsTo('App\Models\Apartment');
    }
}
