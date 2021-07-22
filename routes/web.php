<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/test', function () use ($router) {
    return "Testing Rusunawa";
});

// Pengguna
$router->post('/pengguna/validasi', 'ExampleController@validasiPengguna');
$router->post('/pengguna/login', 'ExampleController@loginPengguna');
$router->post('/pengguna', 'ExampleController@registerPengguna');
$router->get('/pengguna/{id}', 'ExampleController@getPengguna');
$router->put('/pengguna/{id}', 'ExampleController@editPengguna');

// Rusunawa
$router->get('/rusunawa/pengguna/info/{id}', 'ExampleController@getInfoRusunawa');
$router->get('/rusunawa/all', 'ExampleController@getSemuaRusunawa');
$router->get('/rusunawa/pengguna/{id}','ExampleController@getPenggunaRusunawa');
$router->get('/rusunawa/{id}', 'ExampleController@getRusunawa');
$router->post('/rusunawa/insert', 'ExampleController@insertRusunawa');
$router->put('/rusunawa/edit/{id}', 'ExampleController@editRusunawa');
$router->delete('/rusunawa/{id}', 'ExampleController@deleteRusunawa');