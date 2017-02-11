<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Weight extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'weight', 'weigh_in_date', 'user_id'
    ];

    public function setWeighInDateAttribute($value)
    {
        $weightInDate = new Carbon($value);
        $this->attributes['weigh_in_date'] = $weightInDate->format('Y-m-d');
    }

    public function getWeighInDateAttribute()
    {
        $weightInDate = new Carbon($value);
        return $this->attributes['weigh_in_date']
    }
}
