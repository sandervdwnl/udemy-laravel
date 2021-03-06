<?php

use App\Http\Controllers\HobbyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('starting_page');
});

Route::get('/info', function () {
    return view('info');
});

Route::resource('user', 'UserController');

// // Directs URL /test to index-function in HobbyController
// Route::get('/test', 'HobbyController@index');

// Restfull Controller. Creert CRUD routes met names
// Gebruik php artisan route:list resource HobbyController --name=hobby om deze te zien
// URL: /hobby Syntax: resource::name, controller. 
Route::resource('hobby', 'HobbyController');

// Tags
Route::resource('tag', 'TagController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Link naar getFilteredHobbies-functie ex hobbyTagController
Route::get('/hobby/tag/{tag_id}', 'hobbyTagController@getFilteredHobbies')->name('hobby_tag');

// Attach
Route::get('/hobby/{hobby_id}/tag/{tag_id}/attach', 'hobbyTagController@attachTag');

// Detach
Route::get('/hobby/{hobby_id}/tag/{tag_id}/detach', 'hobbyTagController@detachTag');

// Delete hobby image
Route::get('/delete-images/hobby/{hobby_id}', 'hobbyController@deleteImages');

// Delete user image
Route::get('/delete-images/user/{user_id}', 'userController@deleteImages');
