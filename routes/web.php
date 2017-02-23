<?php

use Carbon\Carbon;

$app->get('/', function () use ($app) {
    return 'Nothing to see here.';
});

$app->group(['prefix' => 'api'], function () use ($app) {
    $app->get('/weights', 'WeightController@index');
    $app->get('/weights/{id}', 'WeightController@read');
    $app->post('/weights', 'WeightController@create');
    $app->delete('/weights/{id}', 'WeightController@delete');
    $app->put('/weights/{id}', 'WeightController@update');
});

