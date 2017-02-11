<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'weight', 'weigh_in_date',
    ];
}

curl -X POST -d '{"weight" : "166.0", "date" : "2017-02-11"}' \
  'https://https://watch-yo-weight.firebaseio.com/weights.json'
