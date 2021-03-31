<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

Route::get('/', function () {    
    return view('auth/login');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');

Route::get('empresa', function () {
    return 'empresa';
});

Route::middleware(['auth'])->group(function () {

    Route::view('vagas'/* url */, 'vagas' /* view */);
    Route::get('/dashboard', 'DashboardController@data');
    Route::view('movimientos', 'movimientos');
    Route::view('tarifas', 'tarifas');
    Route::view('tipos', 'tipos')->middleware('permission:tipos_index');
    Route::view('empresa', 'empresa');
    Route::view('cliente', 'cliente');
    Route::view('fabricantes', 'fabricantes');
    Route::view('modelos', 'modelos');
    Route::view('vendas', 'vendas');
    Route::view('vendasdiarias', 'vendasdiarias');
    Route::view('vendasporperiodo', 'vendasporperiodo');
    Route::view('vendasmensalistas', 'vendasmensalistas');
    Route::view('ticketextraviados', 'ticketextraviados');
    Route::view('fechamentoscaixas', 'fechamentoscaixas');
    Route::view('permissao', 'permissao');

});

/**Rota Admin ->middleware('auth') */
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('auth')->group(function(){

        Route::resources([
            'usuarios'     => 'UserController'
        ]);
});

//Rotas para Impressão
Route::get('print/order/{id}', 'PrinterController@TicketVisita');
Route::get('print/mensal/{id}', 'PrinterController@TicketMensal');
Route::view('perfil', 'perfil');
//|tipos_create|tipos_edit|tipos_destroy