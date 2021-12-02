<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['apartment_id', 'email', 'message', 'name', 'surname'];
}
