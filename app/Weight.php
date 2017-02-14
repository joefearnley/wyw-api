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

    public function setWeighInDateAttribute($weightInDate)
    {
        $this->attributes['weigh_in_date'] = Carbon::parse($weightInDate)->format('Y-m-d');
    }

    public function getWeighInDateAttribute()
    {
        return Carbon::parse($this->attributes['weigh_in_date'])->format('d/m/Y');
    }
}
