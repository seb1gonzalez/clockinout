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

$router->group(['prefix' => 'api'], function () use ($router) {

    // EMPLOYEES

    $router->get('pinLookUp/{pin}',  ['uses' => 'employeeController@pinLookUp']);

    $router->get('inorout/{id}',  ['uses' => 'employeeController@inorout']);

    $router->get('employees',  ['uses' => 'employeeController@showAllEmployees']);

    $router->get('employee/{id}',  ['uses' => 'employeeController@employee']);

    $router->get('employeesOut',  ['uses' => 'employeeController@employeesOut']);

    $router->post('employees',  ['uses' => 'employeeController@addEmployee']);

    $router->put('updateEmployee/{id}',  ['uses' => 'employeeController@updateEmployee']);

    // LOGS

    $router->post('clockinorout/{id}',  ['uses' => 'logsController@clockinorout']);
    
    $router->get('usersLogs',  ['uses' => 'logsController@usersLogs']);

    $router->get('userLogs/{id}',  ['uses' => 'logsController@userLogs']);

  });