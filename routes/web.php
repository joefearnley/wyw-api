<?php

use Carbon\Carbon;

$app->get('/', function () use ($app) {
    return 'Nothing to see here.';
});

$app->group(['prefix' => 'api'], function () use ($app) {
    $app->get('/weights', 'WeightController@all');
});

