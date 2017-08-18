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

Route::get('/profile/{id}','UserController@viewProfile')->name('profile')->middleware('auth');
Route::get('/edit-profile/{id}','UserController@edit')->name('edit-profile')->middleware('auth');
Route::get('/delete-user/{id}','UserController@delete')->name('delete-user')->middleware('auth');
Route::post('/update-profile/{id}','UserController@update')->name('update-profile')->middleware('auth');
Route::get('/users','UserController@index')->name('users')->middleware('auth');
Route::get('/users-list','UserController@listUsers')->name('users-list')->middleware('auth');
Route::post('/add-user','UserController@addUsers')->name('add-user')->middleware('auth');

Route::get('/hours', function () {
    return view('layouts.app');
})->name('hours')->middleware('auth');

/** Route for teams **/
Route::get('/teams','TeamController@index')->name('teams')->middleware('auth');
Route::get('/teams-list','TeamController@listTeams')->name('teams-list')->middleware('auth');
Route::post('/add_team','TeamController@store')->name('add_team')->middleware('auth');
Route::get('/delete_team/{id}','TeamController@destroy')->name('delete_team')->middleware('auth');
Route::get('/edit_team/{id}','TeamController@edit')->name('edit_team')->middleware('auth');
Route::post('/update_team/{id}','TeamController@update')->name('update_team')->middleware('auth');

/** Route for roles **/
Route::get('/roles','RoleController@index')->name('roles')->middleware('auth');
Route::get('/roles-list','RoleController@listRoles')->name('roles-list')->middleware('auth');
Route::post('/add_role','RoleController@store')->name('add_role')->middleware('auth');
Route::get('/delete_role/{id}','RoleController@destroy')->name('delete_role')->middleware('auth');
Route::get('/edit_role/{id}','RoleController@edit')->name('edit_role')->middleware('auth');
Route::post('/update_role/{id}','RoleController@update')->name('update_role')->middleware('auth');


/** Routes for permissions **/
Route::get('/permissions','PermissionController@index')->name('permissions')->middleware('auth');
Route::get('/permission-list','PermissionController@listPermissions')->name('permission-list')->middleware('auth');
Route::post('/add_permission','PermissionController@store')->name('add_permission')->middleware('auth');
Route::get('/delete_permission/{id}','PermissionController@destroy')->name('delete_permission')->middleware('auth');
Route::get('/edit_permission/{id}','PermissionController@edit')->name('edit_permission')->middleware('auth');
Route::post('/update_permission/{id}','PermissionController@update')->name('update_permission')->middleware('auth');


Auth::routes();