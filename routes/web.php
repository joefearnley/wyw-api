<?php

use Carbon\Carbon;

$app->get('/', function () use ($app) {
    return 'Nothing to see here.';
});

$app->get('/weights', 'WeightController@all');

$app->get('/add-weight', 'WeightController@save');

$app->get('time-test', function() {
    $newDate = new Carbon('3/21/2016');
    
    echo '<pre>';
    var_dump($newDate->format('Y-m-d'));
    die();
});