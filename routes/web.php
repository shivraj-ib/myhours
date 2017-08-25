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
    return view('layouts.app');
})->name('home');

Route::get('/profile/{id}','UserController@viewProfile')->name('profile');
Route::get('/edit-profile/{id}','UserController@edit')->name('edit-profile');
Route::get('/delete-user/{id}','UserController@delete')->name('delete-user');
Route::post('/update-profile/{id}','UserController@update')->name('update-profile');
Route::get('/users/','UserController@index')->name('users');
Route::get('/users-list','UserController@listUsers')->name('users-list');
Route::post('/add-user','UserController@addUsers')->name('add-user');
Route::post('/add-profile-pic/{id}','UserController@addProfilePic')->name('add-profile-pic');
Route::get('/del-profile-pic/{id}','UserController@delProfilePic')->name('del-profile-pic');
Route::get('/profile-details/{id}','UserController@getProfileDetails')->name('profile-details');

/** Routes for hours modal **/
Route::get('/hours/{id}','HourController@index')->name('hours');
Route::get('/hours-list/{id?}','HourController@listHours')->name('hours-list');
Route::post('/add_hour/{id?}','HourController@store')->name('add_hour');
Route::get('/delete_hour/{id}','HourController@destroy')->name('delete_hour');
Route::get('/edit_hour/{id}','HourController@edit')->name('edit_hour');
Route::post('/update_hour/{id}','HourController@update')->name('update_hour');

/** Route for teams **/
Route::get('/teams','TeamController@index')->name('teams');
Route::get('/teams-list','TeamController@listTeams')->name('teams-list');
Route::post('/add_team','TeamController@store')->name('add_team');
Route::get('/delete_team/{id}','TeamController@destroy')->name('delete_team');
Route::get('/edit_team/{id}','TeamController@edit')->name('edit_team');
Route::post('/update_team/{id}','TeamController@update')->name('update_team');

/** Route for roles **/
Route::get('/roles','RoleController@index')->name('roles');
Route::get('/roles-list','RoleController@listRoles')->name('roles-list');
Route::post('/add_role','RoleController@store')->name('add_role');
Route::get('/delete_role/{id}','RoleController@destroy')->name('delete_role');
Route::get('/edit_role/{id}','RoleController@edit')->name('edit_role');
Route::post('/update_role/{id}','RoleController@update')->name('update_role');


/** Routes for permissions **/
Route::get('/permissions','PermissionController@index')->name('permissions');
Route::get('/permission-list','PermissionController@listPermissions')->name('permission-list');
Route::post('/add_permission','PermissionController@store')->name('add_permission');
Route::get('/delete_permission/{id}','PermissionController@destroy')->name('delete_permission');
Route::get('/edit_permission/{id}','PermissionController@edit')->name('edit_permission');
Route::post('/update_permission/{id}','PermissionController@update')->name('update_permission');


Auth::routes();