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
    $router->delete('/product/remove/{id}', 'ProductsController@removeProduct');
    $router->put('/product/update/{id}','ProductsController@updateProduct');  // nao envia para a BD
    
    //upload Image
    $router->post('/product/img/{id}','UploadController@upload');

    //Categories
    $router->post('/categories/add','CategoriesController@addCategories');
    $router->put('/categorie/update/{id}', 'CategoriesController@updateCategorie');
    $router->delete('/categorie/remove/{id}', 'CategoriesController@removeCategorie');
    

    //Subcategories
    $router->post('/subcategories/add', 'SubcategoriesController@addSubCategories');
    $router->put('/subcategorie/update/{id}','SubcategoriesController@updateSubCategorie');
    $router->delete ('/subcategorie/remove/{id}', 'SubcategoriesController@removeSubCategorie');

    //User
    $router->put('/user/{user_id}','UsersController@updateUser');
    $router->post('/user/add', 'UsersController@newUser');
    $router->get('/auth/user','AuthController@me');//authenticate user
    $router->get('/user/info/{id}', 'UsersController@getUserInfo');
    $router->put('/user/info/{id}', 'UsersController@updateUserInfo');
    
    //Orders
    $router->get('/order','OrderController@getOrder');
    $router->get('/order/{id}','OrderController@getOrderById');
    $router->post('/order', 'OrderController@addOrder');

    // Acessos
    $router->post('/logout','AuthController@logout');//logout
    $router->get('/auth/user','AuthController@me'); //autenticação
});

$router->get('/products', 'ProductsController@getProducts');
$router->get('/products/{id}','ProductsController@getProduct');
$router->get('/categories', 'CategoriesController@getCategories');
$router->get('/subcategories', 'SubcategoriesController@getSubCategories');
$router->get('/product/imgs','UploadController@getImages');

$router->get('/product/imgs/{id}','UploadController@getImage');

$router->post('/login', 'AuthController@login'); //login
$router->post('/register', 'UsersController@register'); // Register new user

