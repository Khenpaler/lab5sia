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

//no authentication
//$router->group([],function() use ($router){


//with authentication using the middleware
$router->group(['middleware' => 'client.credentials'],function() use ($router){

    //API GATEWAY ROUTES FOR SITE1 USERS
    $router->post('/add/users1',['uses' => 'User1Controller@addUser']); //1 

    $router->delete('/delete/users1/{id}',['uses' => 'User1Controller@deleteUser']); //2

    $router->put('/update/users1/{id}',['uses' => 'User1Controller@updateUser']); //3

    $router->get('/find/users1/{id}',['uses' => 'User1Controller@showUser']); //4

    $router->get('/show/users1', 'User1Controller@showALLUSERS'); //5


    //API GATEWAY ROUTES FOR SITE2 USERS
    $router->post('/add/users2',['uses' => 'User2Controller@addUser']); //1

    $router->delete('/delete/users2/{id}',['uses' => 'User2Controller@deleteUser']); //2

    $router->put('/update/users2/{id}',['uses' => 'User2Controller@updateUser']); //3

    $router->get('/find/users2/{id}',['uses' => 'User2Controller@showUser']); //4

    $router->get('/show/users2',['uses' => 'User2Controller@showALLUSERS']); //5

});