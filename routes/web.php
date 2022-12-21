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
    $router->post('/product', 'ProductsController@addProducts');
    // $router->delete('/product/{id}', 'ProductsController@removeProduct');
    $router->put('/product/{id}','ProductsController@updateProduct');
    
    //upload Image
    $router->post('/product/img/{id}','UploadController@upload');
    $router->post('/product/img', 'UploadController@uploadNewImage');

    //Categories
    $router->post('/categories','CategoriesController@addCategories');
    $router->put('/category/{id}', 'CategoriesController@updateCategorie');
    $router->delete('/category/{id}', 'CategoriesController@removeCategorie');

    //Subcategories
    $router->post('/subcategories', 'SubcategoriesController@addSubCategories');
    $router->put('/subcategorie/{id}','SubcategoriesController@updateSubCategorie');
    $router->delete ('/subcategorie/{id}', 'SubcategoriesController@removeSubCategorie');

    //User
    $router->put('/user/{user_id}','UsersController@updateUser');
    $router->post('/user', 'UsersController@newUser');
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

//filter
$router->post('/search','ProductsController@filter');



//get products, categories, sub-categories
$router->get('/products', 'ProductsController@getProducts');
$router->get('/products/{id}','ProductsController@getProduct');
$router->get('/categories', 'CategoriesController@getCategories');
$router->get('/subcategories', 'SubcategoriesController@getSubCategories');

$router->get('/subcategory/{id}', 'ProductsController@getSubCategoryById');

//images
$router->get('/product/imgs','UploadController@getImages');
$router->get('/product/imgs/{id}','UploadController@getImage');

$router->post('/login', 'AuthController@login'); //login
$router->post('/register', 'UsersController@register'); // Register new user

