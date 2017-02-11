<?php

use Carbon\Carbon;

$app->get('/', function () use ($app) {
    return 'Nothing to see here.';
});

$app->get('/weights', 'WeightController@all');

$app->get('/add-weight', 'WeightController@save');