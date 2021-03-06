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

Route::get('/logout', function(){
    Auth::logout();
    return redirect('/');
});

Auth::routes();

Route::get('/empreendimento', 'EmpreendimentoController@index');
Route::get('/empreendimento/detail/{id}', 'EmpreendimentoController@detail');

Route::get('/cliente/adicionar', 'ClienteController@create');
Route::get('/cliente/editar/{id}','ClienteController@edit');
Route::get('/cliente', 'ClienteController@index');
Route::get('/cliente/detail/{id}', 'ClienteController@detail');
Route::post('/cliente/store', 'ClienteController@store');

Route::get('/cidades/por-estado/{id}', 'CidadeController@getByEstado');


Route::group(['middleware' => ['web', 'FiltraAdmin']], function(){
   Route::get('/vendedor/adicionar', 'VendedorController@create');
   Route::get('/vendedor/editar/{id}','VendedorController@edit');
   Route::get('/vendedor', 'VendedorController@index');
   Route::get('/vendedor/detail/{id}', 'VendedorController@detail');
   Route::post('/vendedor/store', 'VendedorController@store');
   
   Route::resource('imobiliaria', 'ImobiliariaController');
   Route::get('/imobiliaria/detail/{id}', 'ImobiliariaController@show');

   Route::get('/trilhadevenda', 'TrilhaDeVendaController@index');
   Route::get('/trilhadevenda/adicionar', 'TrilhaDeVendaController@create');
   Route::post('/trilhadevenda/store','TrilhaDeVendaController@store');
   Route::get('/trilhadevenda/editar/{id}', 'TrilhaDeVendaController@edit');
   Route::get('/trilhadevenda/detail/{id}', 'TrilhaDeVendaController@detail');
   Route::get('/trilhadevenda/config/{id}','TrilhaDeVendaController@config');
   Route::post('/trilhadevenda/salvarconfig','TrilhaDeVendaController@salvarConfig');

   Route::get('/etapa', 'EtapaController@index');
   Route::get('/etapa/adicionar','EtapaController@create');
   Route::get('/etapa/detail/{id}','EtapaController@detail');
   Route::post('/etapa/store','EtapaController@store');
   
   Route::get('/empreendimento/adicionar', 'EmpreendimentoController@create');
   Route::get('/empreendimento/editar/{id}','EmpreendimentoController@edit');
   Route::post('/empreendimento/store', 'EmpreendimentoController@store');
   Route::post('/empreendimento/update/{id}', 'EmpreendimentoController@update');
});

Route::get('/venda', 'VendaController@index');
Route::post('/venda', 'VendaController@index');
Route::get('/venda/detail/{id}','VendaController@detail');
Route::get('/venda/adicionar', 'VendaController@create');
Route::post('/venda/store', 'VendaController@store');
Route::get('/venda/{id}/concluir-etapa-em-andamento', 'VendaController@concluirEtapaEmAndamento');
Route::get('/venda/{id}/excluirJustificativa', 'VendaController@excluirJustificativa');
Route::get('/venda/{id}/salvarJustificativa/{texto}', 'VendaController@salvarJustificativa');
Route::get('/venda/{vendaId}/mudar-status-subetapa/{subEtapId}', 'VendaController@mudarStatusSubEtapa');
Route::get('/venda/{id}/mudar-status/{status}', 'VendaController@mudarStatusVenda');
Route::get('/pendencias','VendaController@pendencies');

Route::get('/logs', 'LogController@index');

Route::get('/home', 'HomeController@index')->name('home');
