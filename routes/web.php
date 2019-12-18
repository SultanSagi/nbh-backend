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

// $router->group(['prefix' => 'api'], function() use ($router) {
//     $router->post('register', 'AuthController@register');
//     $router->post('login', 'AuthController@login');
// });

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'client', 'namespace' => 'Client'], function () use ($router) {
        $router->get('dashboard', 'UsersController@show');
    });

    $router->group(['prefix' => 'user', 'namespace' => 'User'], function () use ($router) {
        $router->post('register', 'AuthController@register');
        $router->post('login', 'AuthController@login');

        $router->get('dashboard', 'UsersController@index');
        $router->get('clients/{user}', 'UsersController@show');
        $router->patch('clients/{user}/edit', 'UsersController@update');
    });
});

// $router->group(['prefix' => 'api'], function () use ($router) {

   


//     $router->get('profile', 'UsersController@profile');


//     $router->get('users/{id}', 'UsersController@singleUser');


//     $router->get('users', 'UsersController@allUsers');
// });