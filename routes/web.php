<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
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
    echo "只有登陆用户可以查看";
})->middleware('auth');

Route::get('test',function(){

    $collection = collect(['aaa','aaa','bbb',null])->map(function($name){
        return strtoupper($name);
    })->reject(function($name){
        return empty($name);
    });
    dd($collection);
})->name('test');

Route::get('command',function(){
    \Illuminate\Support\Facades\Artisan::call('build test');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
