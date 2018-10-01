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
	#dump(config('mail.supportEmail'));
	#dump(config('mail'));
    return view('welcome');
})->name('home');

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


Auth::routes();

Route::get('/quienEstaConectado', function () {
    $user = Auth::user();

    if ($user) {
        dump('Estas conectado como:', $user->toArray());
    } else {
        dump('No hay nadie conectado conectado');
    }

    return;
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/usuarios', 'UsuarioController@lista');

    Route::get('/registraUsuario',function () {
        return view('auth.register');
    });

    #Route::get('/', 'ProyectoController@lista');

    Route::get('/proyectos/{idCli?}',
        ['middleware' => 'auth',
        'uses' =>'ProyectoController@lista'
        ])->name('proyectos');

    Route::get('/proyecto/busca', 'ProyectoController@busca');
    Route::get('/proyecto/guardar/{id?}/{idCli?}', 'ProyectoController@guardar');
    Route::post('/proyecto/guardar/{id?}/{idCli?}', 'ProyectoController@guardar');
    Route::get('/proyecto/{id?}/{idCli?}', 'ProyectoController@proyecto')->name('proyecto');;
    Route::get('/proyectoPDF/bajaPDF/{id}/{iva}','ProyectoController@bajaPDF');
    Route::get('/proyectoPDF/bajaPDFSaldo/{id}','ProyectoController@bajaPDFSaldo');

    Route::get('/concepto/eliminar/{id?}', 'ConceptoController@eliminar');
    Route::get('/concepto/guardar/{id?}', 'ConceptoController@guardar');
    Route::post('/concepto/guardar/{id?}', 'ConceptoController@guardar');
    Route::get('/concepto/{id?}/{idproy?}', 'ConceptoController@concepto')->name('concepto');
    #{tipoMensaje?}/{mensaje?

    Route::get('/conceptoElemento/eliminar/{idCon}/{idEle?}/{edit?}', 'ConceptoElementoController@eliminar');
    Route::get('/conceptoElemento/guardar/{idCon}/{idEle?}/{edit?}', 'ConceptoElementoController@guardar');
    Route::post('/conceptoElemento/guardar/{idCon}/{idEle?}/{edit?}', 'ConceptoElementoController@guardar');
    Route::get('/conceptoElemento/{idCon}/{idEle?}/{edit?}', 'ConceptoElementoController@conceptoElemento')->name('subConcepto');

    Route::get('/elementos', 'ElementoController@lista')->name('elementos');
    Route::get('/elemento/guardar/{id?}/{idCon?}', 'ElementoController@guardar');
    Route::post('/elemento/guardar/{id?}/{idCon?}', 'ElementoController@guardar');
    Route::get('/elemento/{id?}/{idCon?}', 'ElementoController@elemento')->name('elemento');

    Route::get('/cotizaciones', 'CotizacionController@lista')->name('cotizaciones');
    Route::get('/cotizacion/guardar/{id?}', 'CotizacionController@guardar');
    Route::post('/cotizacion/guardar/{id?}', 'CotizacionController@guardar');
    Route::get('/cotizacion/{id?}/{idProy?}', 'CotizacionController@cotizacion')->name('cotizacion');
    Route::get('/cotizacionNew/{idCon}/{idEle}/{idProy?}','CotizacionController@creaCotizacion');

    Route::get('/cuentas', 'CuentaController@lista');

    Route::get('/recursos', 'RecursoController@lista');
    Route::get('/distribuir/{id}', 'MovimientoController@distribuir');
    Route::get('/distribuirAdicionales/{id}', 'MovimientoController@distribuirAdicionales');

    Route::get('/movimientos', 'MovimientoController@lista')->name('movimientos');
    Route::get('/movimiento/guardar/{id?}/{idRec?}/{idCue?}', 'MovimientoController@guardar');
    Route::post('/movimiento/guardar/{id?}/{idRec?/{idCue?}}', 'MovimientoController@guardar');
    Route::get('/movimiento/{id?}/{idRec?}/{idCue?}', 'MovimientoController@movimiento')->name('movimiento');

    Route::get('/proveedores', 'ProveedoreController@lista')->name('proveedores');
    Route::get('/proveedor/guardar/{id?}', 'ProveedoreController@guardar');
    Route::post('/proveedor/guardar/{id?}', 'ProveedoreController@guardar');
    Route::get('/proveedor/{id?}/{idCoti?}', 'ProveedoreController@proveedore');

    Route::get('/clientes', 'ClienteController@lista')->name('clientes');
    Route::get('/cliente/guardar/{id?}', 'ClienteController@guardar');
    Route::post('/cliente/guardar/{id?}', 'ClienteController@guardar');
    Route::get('/cliente/{id?}/{idProy?}', 'ClienteController@cliente')->name('cliente');

    Route::get('/clientepago/guardar/{id?}/{idCli?}/{idProy?}', 'PagosClienteController@guardar');
    Route::post('/clientepago/guardar/{id?}/{idCli?}/{idProy?}', 'PagosClienteController@guardar');
    Route::get('/proveedorpago/guardar/{id?}/{idPro?}/{idCot?}', 'PagosProveedoreController@guardar');
    Route::post('/proveedorpago/guardar/{id?}/{idPro?}/{idCot?}', 'PagosProveedoreController@guardar');

    Route::get('/pagosClientes', 'PagosClienteController@lista');
    Route::get('/pagoCliente/{id?}/{idCli?}/{idProy?}', 'PagosClienteController@pagoCliente')->name('pagoCliente');

    Route::get('/pagosProveedores', 'PagosProveedoreController@lista');
    Route::get('/pagoProveedor/{id?}/{idPro?}/{idCot?}', 'PagosProveedoreController@pagoProveedore')->name('pagoProveedor');

    Route::get('/information/create/ajax-proveedoresElemento/{id?}','ElementoController@proveedoresElemento');
    Route::get('/information/create/ajax-elementoCostoGanancia/{id?}','ElementoController@elementoCostoGanancia');
});
