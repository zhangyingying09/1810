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
    return view('welcome');
});
Route::get('/user/login','User\UserController@login');

Route::resource('/goods', 'Goods\GoodsController');
//curl测试
Route::get('/text/curl1','Text\TextController@curl1');
Route::get('/text/curl2','Text\TextController@curl2');
Route::post('/text/curl3','Text\TextController@curl3');
Route::post('/text/curl4','Text\TextController@curl4');
Route::get('/text/curl5','Text\TextController@curl5');
//加密
Route::get('/text/add','Text\TextController@add');
Route::get('/text/add1','Text\TextController@add1');
Route::get('/text/add2','Text\TextController@add2');

Route::get('/text/form1','Text\TextController@form1');
Route::post('/text/form1','Text\TextController@form1post');


Route::get('/text/form2','Text\TextController@form2');
Route::post('/text/form2','Text\TextController@form2post');


Route::get('/text/sign','Text\TextController@sign');
Route::post('/text/sign1','Text\TextController@sign1');
Route::get('/text/o1','Text\TextController@o1');