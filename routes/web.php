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

$router->group(['prefix' => 'order'], function () use ($router) {
    $router->post('create', 'OrderController@creatOrder');
    $router->get('all', 'OrderController@getAllOrders');
    $router->get('order/{id}', 'OrderController@getOrder');
    $router->post('update', 'OrderController@updateOrder');
});

$router->group(['prefix' => 'customer'], function () use ($router) {
    $router->post('create', 'CustomerController@creatCustomer');
    $router->get('all', 'CustomerController@getAllCustomers');
    $router->get('customer/{id}', 'CustomerController@getCustomer');
    $router->post('update', 'CustomerController@updateCustomer');
});

$router->group(['prefix' => 'item'], function () use ($router) {
    $router->post('create', 'ItemController@creatItem');
    $router->get('all', 'ItemController@getAllItems');
    $router->get('item/{id}', 'ItemController@getItem');
    $router->post('update', 'ItemController@updateItem');
});

$router->group(['prefix' => 'cart'], function () use ($router) {
    $router->post('addToCart', 'CartController@addToCart');
    $router->post('removeFromCart', 'CartController@removeFromCart');
    $router->get('allCustomerCartItems/{customer_id}', 'CartController@getAllCartItems');
    $router->get('cart/{id}', 'CartController@getCart');
    $router->post('update', 'CartController@updateCart');
});

$router->group(['prefix' => 'checkout'], function () use ($router) {
    $router->post('cartCheckout', 'CheckoutController@checkout');
});
