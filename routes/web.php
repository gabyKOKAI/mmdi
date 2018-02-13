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
	dump(config('mail.supportEmail'));
	dump(config('mail'));
    return view('welcome');
});

# New route returs string Hola Mundo
Route::get('/prueba', function () {
    return 'Hola Mundo!';
});

# Nueva rutina con parametro
Route::get('/parametro/{valor}', function($valor) {
	return 'Paramentro es: '.$valor;
});

#Parametro Opcional
Route::get('/parametroOpcional/{valor?}', function($valor = '') {

    if($valor == '') {
        return 'No enviaste parametro';
    }
    else {
	    return 'Parametro es: '.$valor;
    }

});

Route::get('/proyecto/busca', 'ProyectoController@search');
Route::get('/proyecto/agrega', 'ProyectoController@agrega');
Route::get('/proyectos', 'ProyectoController@lista');
Route::post('/proyecto/guarda', 'ProyectoController@guarda');