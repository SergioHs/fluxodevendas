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
Route::post('/cliente/store', 'ClienteController@store');


Route::get('/cidades/por-estado/{id}', 'CidadeController@getByEstado');