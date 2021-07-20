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

// Pengguna
$router->post('/pengguna/validasi', 'PasienController@validasiPengguna');
$router->post('/pengguna/login', 'PasienController@loginPengguna');
$router->post('/pengguna', 'PasienController@registerPengguna');
$router->get('/pengguna/{id}', 'PasienController@getPengguna');
$router->put('/pengguna/{id}', 'PasienController@editPengguna');

// Rusunawa
$router->get('/rusunawa', 'PasienController@getSemuaRusunawa');
$router->get('/rusunawa/{id}', 'PasienController@getRusunawa');
$router->post('/rusunawa', 'PasienController@editRusunawa');
$router->delete('/rusunawa/{id}', 'PasienController@deleteRusunawa');