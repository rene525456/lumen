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

$router->group(['prefix' => 'usuarios'], function($router){
	$router->get('users','UserController@index');
	$router->post('users','UserController@login');
});

$router->group(['prefix' => 'cliente'], function($router){
	$router->get('get/{cedula}','ClienteController@getCliente');
	$router->get('cuentas/{cedula}','ClienteController@getCuentas');
	$router->get('cuenta/{numero}','ClienteController@getCuenta');
	
	//$router->post('users','UserController@login');
});