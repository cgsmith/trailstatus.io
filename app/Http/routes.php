<?php

$app->get('/', [
    'uses' => 'App\Http\Controllers\TrailController@index'
]);

$app->get('/json', [
    'uses' => 'App\Http\Controllers\TrailController@index'
]);

$app->get('/update/{token}', [
    'uses' => 'App\Http\Controllers\TrailController@update'
]);

$app->post('/recording', [
    'uses' => 'App\Http\Controllers\TrailController@persist'
]);