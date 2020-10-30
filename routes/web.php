<?php

use App\Http\Controllers\HobbyController;
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

// // Directs URL /test to index-function in HobbyController
// Route::get('/test', 'HobbyController@index');


// Restfull Controller. Creert CRUD routes met names
// Gebruik php artisan route:list resource HobbyController --name=hobby om deze te zien
// URL: /hobby Syntax: resource::name, controller. 
Route::resource('hobby', 'HobbyController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
