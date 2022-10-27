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

$router->group(['middleware'=>'jwt.verify'],function($router) {

    $router->post('/logout','AuthController@logout');//logout

});


$router->post('/login', 'AuthController@login'); //login

$router->post('/register', 'UsersController@newUser'); // Register new user

$router->get('/{id}','UsersController@getUser');