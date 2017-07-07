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

Route::get('/empreendimento', 'EmpreendimentoController@index');
Route::post('/empreendimento/adicionar', 'EmpreendimentoController@store');
Route::get('/empreendimento/adicionar', 'EmpreendimentoController@create');

Route::get('/cliente/adicionar', 'ClienteController@create');
Route::get('/cliente', 'ClienteController@index');
Route::get('/cliente/detail/{id}', 'ClienteController@detail');
Route::post('/cliente/store', 'ClienteController@store');

Route::get('/vendedor/adicionar', 'App\Http\VendedorController@create');
Route::get('/vendedor', 'App\Http\VendedorController@index');
Route::get('/vendedor/detail/{id}', 'App\Http\VendedorController@detail');
Route::post('/vendedor/store', 'App\Http\VendedorController@store');

Route::get('/cidades/por-estado/{id}', 'CidadeController@getByEstado');