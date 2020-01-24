<?php
//use Illuminate\Support\Facades\Route;
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
   // return $router->app->version();
    echo "Hello from Me!";
});

$router->post('/try', function () use ($router) {
    // return $router->app->version();
     echo "Hello from MeMe!";
 });

 $router->post('/auth/login',
  'ExampleController@postLogin');

  $router->post('/auth/register',
  'ExampleController@postRegister');

  $router->get('/users',
  'ExampleController@getUsers');

  $router->get('/users/{id}',
  'ExampleController@getUsersById');

  $router->post('/deleteuser/{id}',
  'ExampleController@deleteUsers');

  $router->group(['middleware'=>'auth' ], function($router){

    $router->post('/test',
    'ExampleController@Test');
  });



$router->get('orders',['as'=>'orders.index','uses'=>'OrderController@index']);
$router->post('orders/create',['as'=>'orders.store','uses'=>'OrderController@store']);
$router->get('orders/edit/{id}',['as'=>'orders.edit','uses'=>'OrderController@edit']);
$router->patch('orders/{id}',['as'=>'orders.update','uses'=>'OrderController@update']);
$router->delete('orders/{id}',['as'=>'orders.destroy','uses'=>'OrderController@destroy']);
$router->get('orders/{id}',['as'=>'orders.view','uses'=>'OrderController@view']);