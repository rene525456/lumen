<?php

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

$router->group(['prefix' => 'cliente'], function($router){
    $router->get('all','ClienteController@all');
    $router->get('allJson','ClienteController@allJson');
    $router->get('getCliente/{cedula}','ClienteController@getClienteCedula');
    $router->get('getCuentas/{cedula}','ClienteController@getCuentas');
    $router->post('create','ClienteController@create');
});

$router->group(['prefix' => 'transacciones'], function($router){
    $router->post('depositar','TransaccionController@depositar');
});
