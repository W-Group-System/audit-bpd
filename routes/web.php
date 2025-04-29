<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Users
Route::get('users', 'UserController@index');
Route::post('store_user', 'UserController@store');
Route::post('update_user/{id}', 'UserController@update');
Route::post('deactivate_user', 'UserController@deactivate');
Route::post('activate_user', 'UserController@activate');

// Company
Route::get('companies', 'CompanyController@index');

// Department
Route::get('departments', 'DepartmentController@index');

// CAR
Route::get('corrective-action-request', 'CorrectiveActionRequestController@index');
Route::post('store_car', 'CorrectiveActionRequestController@store');
