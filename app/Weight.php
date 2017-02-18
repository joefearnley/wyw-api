<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Weight extends Model 
{
    protected $fillable = [
        'weight',
        'weigh_in_date',
        'user_id'
    ];

    public function setWeighInDateAttribute($weighInDate)
    {
        $this->attributes['weigh_in_date'] = Carbon::parse($weighInDate)->format('Y-m-d');
    }

    public function getWeighInDateAttribute()
    {
        $wieghInDate = Carbon::parse($this->attributes['weigh_in_date'])->format('n/j/Y');

        return $wieghInDate;
    }
}
