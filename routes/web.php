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

use App\Mail\NotifyEmail;
use App\User;

Route::get('/', function () {
    // return view('welcome');
    return redirect('login');
});

Auth::routes();
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/home', 'HomeController@index')->name('home');

// Users
Route::get('users', 'UserController@index');
Route::post('store_user', 'UserController@store');
Route::post('update_user/{id}', 'UserController@update');
Route::post('deactivate_user', 'UserController@deactivate');
Route::post('activate_user', 'UserController@activate');
Route::post('change_password/{id}','UserController@change_password');

// Company
Route::get('companies', 'CompanyController@index');

// Department
Route::get('departments', 'DepartmentController@index');
Route::post('store_department', 'DepartmentController@store');
Route::post('update_department/{id}', 'DepartmentController@update');
Route::post('deactivate_department', 'DepartmentController@deactivate_department');
Route::post('activate_department', 'DepartmentController@activate_department');

// CAR
Route::get('corrective-action-request', 'CorrectiveActionRequestController@index');
Route::post('store_car', 'CorrectiveActionRequestController@store');
Route::post('update_car/{id}', 'CorrectiveActionRequestController@update');
Route::post('refresh_dept_head', 'CorrectiveActionRequestController@refreshDeptHead');
Route::post('verify_car/{id}', 'CorrectiveActionRequestController@verify');
Route::post('update_admin/{id}','CorrectiveActionRequestController@updateAdmin');

// For Review
Route::get('for-approval', 'ForReviewController@index');
Route::post('car_action', 'ForReviewController@store');
Route::get('show_verification/{id}', 'ForReviewController@show');
Route::post('verify_action', 'ForReviewController@verifyAction');

// Route::get('mailable', function () {
//     $user = User::find(3);

//     return new NotifyEmail($user);
// });