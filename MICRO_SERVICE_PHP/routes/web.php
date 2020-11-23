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

// USERS //
  // CREATE //
  $router->post('user/create', 'UserController@create');

  // READ //
  $router->get('user/all', 'UserController@readAll');
  $router->get('user/{id}', 'UserController@readOne');

  // DESTROY //
  $router->get('user/delete/{id}', 'UserController@destroy');

  // LOGIN //
  $router->post('user/login', 'UserController@login');
  
// MESSAGES //
  // CREATE //
  $router->post('message/create', 'MessageController@create');

  // READ //
  $router->get('message/all', 'MessageController@readAll');
  $router->get('message/{id}', 'MessageController@readOne');

  // DESTROY //
  $router->get('message/delete/{id}', 'MessageController@destroy');  


