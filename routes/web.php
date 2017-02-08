<?php

$app->get('/', function () use ($app) {
    return 'Nothing to see here.';
});

$app->get('/weights', 'WeightsController@index');