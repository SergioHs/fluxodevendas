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

Route::get('/empreendimento/adicionar', 'EmpreendimentoController@create');
Route::get('/empreendimento/editar/{id}','EmpreendimentoController@edit');
Route::get('/empreendimento', 'EmpreendimentoController@index');
Route::get('/empreendimento/detail/{id}', 'EmpreendimentoController@detail');
Route::post('/empreendimento/store', 'EmpreendimentoController@store');

Route::get('/cliente/adicionar', 'ClienteController@create');
Route::get('/cliente/editar/{id}','ClienteController@edit');
Route::get('/cliente', 'ClienteController@index');
Route::get('/cliente/detail/{id}', 'ClienteController@detail');
Route::post('/cliente/store', 'ClienteController@store');

Route::get('/vendedor/adicionar', 'VendedorController@create');
Route::get('/vendedor', 'VendedorController@index');
Route::get('/vendedor/detail/{id}', 'VendedorController@detail');
Route::post('/vendedor/store', 'VendedorController@store');

Route::get('/cidades/por-estado/{id}', 'CidadeController@getByEstado');

Route::get('/trilhadevenda', 'TrilhaDeVendaController@index');
Route::get('/trilhadevenda/adicionar', 'TrilhaDeVendaController@create');
Route::post('/trilhadevenda/store','TrilhaDeVendaController@store');
Route::get('/trilhadevenda/editar/{id}', 'TrilhaDeVendaController@edit');
Route::get('/trilhadevenda/detail/{id}', 'TrilhaDeVendaController@detail');


Route::get('/etapa', 'EtapaController@index');
Route::get('/etapa/adicionar','EtapaController@create');
Route::post('/etapa/store','EtapaController@store');