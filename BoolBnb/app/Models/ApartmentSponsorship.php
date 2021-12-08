<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


class ApartmentSponsorship extends Pivot
{
    protected $fillables = ['start_date','end_date'];
}
