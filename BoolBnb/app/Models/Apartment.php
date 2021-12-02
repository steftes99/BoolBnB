<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = ['user_id', 'title', 'rooms', 'beds', 'bathrooms', 'square', 'city', 'country', 'region', 'address', 'lat', 'long', 'image', 'visible'];
}
