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
    //Products
    $router->post('/products/addnew', 'ProductsController@addProducts');
    $router->get('/product/{id}','ProductsController@getProduct');
    $router->delete('/product/remove/{id}', 'ProductsController@removeProduct');
    $router->put('/product/update/{id}','ProductsController@updateProduct');  // nao envia para a BD

    $router->post('/product/{id}/img','UploadController@upload');// nao funciona

    //Categories & SubCategories
    $router->post('/categories/add','CategoriesController@addCategories');
    $router->post('/subcategories/add', 'CategoriesController@addSubCategories');

    $router->put('/categorie/update/{id}', 'CategoriesController@updateCategorie');
    $router->put('/subcategorie/update/{id}','CategoriesController@updateSubCategorie');

    $router->delete('/categorie/remove/{id}', 'CategoriesController@removeCategorie');
    $router->delete ('/subcategorie/remove/{id}', 'CategoriesController@removeSubCategorie');

    //User
    $router->put('/user/{user_id}','UsersController@updateUser');
    $router->post('/user/add', 'UsersController@newUser');
    $router->get('/auth/user','AuthController@me');//authenticate user
    $router->get('/user/info/{id}', 'UsersController@getUser');
    //Orders

    // Acessos
    $router->post('/logout','AuthController@logout');//logout
    $router->get('/auth/user','AuthController@me'); //autenticação
});

$router->get('/products', 'ProductsController@getProducts');

$router->post('/login', 'AuthController@login'); //login
$router->post('/register', 'UsersController@register'); // Register new user

