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

Route::get('/pruebaBD', function () {

    $debug = [
        'Environment' => App::environment(),
        'Database defaultStringLength' => Illuminate\Database\Schema\Builder::$defaultStringLength,
    ];

    /*
    The following commented out line will print your MySQL credentials.
    Uncomment this line only if you're facing difficulties connecting to the
    database and you need to confirm your credentials. When you're done
    debugging, comment it back out so you don't accidentally leave it
    running on your production server, making your credentials public.
    */
    #$debug['MySQL connection config'] = config('database.connections.mysql');

    try {
        $databases = DB::select('SHOW DATABASES;');
        $debug['Database connection test'] = 'PASSED';
        $debug['Databases'] = array_column($databases, 'Database');
    } catch (Exception $e) {
        $debug['Database connection test'] = 'FAILED: '.$e->getMessage();
    }

    dump($debug);
});


Route::get('/proyectos', 'ProyectoController@lista');
Route::get('/proyecto/busca', 'ProyectoController@busca');
Route::get('/proyecto/{id?}', 'ProyectoController@proyecto');
Route::get('/proyecto/guardar/{id?}', 'ProyectoController@guardar');
Route::post('/proyecto/guardar/{id?}', 'ProyectoController@guardar');

Route::get('/concepto/eliminar/{id?}', 'ConceptoController@eliminar');
Route::get('/concepto/guardar/{id?}', 'ConceptoController@guardar');
Route::post('/concepto/guardar/{id?}', 'ConceptoController@guardar');
Route::get('/concepto/{id?}/{idproy?}', 'ConceptoController@concepto');

Route::get('/conceptoElemento/eliminar/{idCon}/{idEle?}', 'ConceptoElementoController@eliminar');
Route::get('/conceptoElemento/guardar/{idCon}/{idEle?}', 'ConceptoElementoController@guardar');
Route::post('/conceptoElemento/guardar/{idCon}/{idEle?}', 'ConceptoElementoController@guardar');
Route::get('/conceptoElemento/{idCon}/{idEle?}', 'ConceptoElementoController@conceptoElemento');
//Route::post('/conceptoElemento/eliminar/{idCon}/{idEle?}', 'ConceptoElementoController@eliminar');

Route::get('/elementos', 'ElementoController@lista');
Route::get('/elemento/guardar/{id?}', 'ElementoController@guardar');
Route::post('/elemento/guardar/{id?}', 'ElementoController@guardar');
Route::get('/elemento/{id?}', 'ElementoController@elemento');