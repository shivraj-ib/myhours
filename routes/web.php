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
    return view('main');
})->name('home');

Route::get('/profile', function () {
    return view('main');
})->name('profile');

Route::get('/hours', function () {
    return view('main');
})->name('hours');

Route::get('/teams','TeamController@index')->name('teams');
Route::post('/add_team','TeamController@store')->name('add_team');
Route::get('/delete_team/{id}','TeamController@destroy')->name('delete_team');
Route::get('/edit_team/{id}','TeamController@edit')->name('edit_team');
Route::post('/update_team/{id}','TeamController@update')->name('update_team');

Route::get('/users', function () {
    return view('main');
})->name('users');

Route::get('/roles', function () {
    return view('main');
})->name('roles');

Route::get('/permissions', function () {
    return view('main');
})->name('permissions');
