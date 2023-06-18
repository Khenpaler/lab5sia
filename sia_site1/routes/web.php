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

// unsecure routes
/*$router->group(['prefix' => 'api'], function () use ($router){
    $router->get('/users',['uses' => 'UserController@getUsers']);
});*/


//$router->get('/users',['uses' => 'UserController@getUsers']);


//more simple routes
// $router->get('/users', 'UserController@index'); // get all users records
// $router->post('/users','UserController@add'); // create new user record
// $router->get('/users/{id}','UserController@show'); // get user by id


//user routers
$router->post('/add/users',['uses' => 'UserController@addUser']); //1

$router->delete('/delete/users/{id}',['uses' => 'UserController@deleteUser']); //2

$router->put('/update/users/{id}',['uses' => 'UserController@updateUser']); //3

$router->get('/find/users/{id}',['uses' => 'UserController@showUser']); //4

$router->get('/show/users',['uses' => 'UserController@showALLUSERS']); //5



//userjob routers
$router->get('/usersjob',['uses' => 'UserJobController@showALLUSERSJOB']); //usersjob all

$router->get('/usersjob/{id}',['uses' => 'UserJobController@showUSERJOB']); //usersjob by ID
