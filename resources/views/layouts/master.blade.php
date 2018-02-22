<!DOCTYPE html>
<html>
<head>
    <title>
        @yield('title', 'MMDI')
    </title>

    <meta charset='utf-8'>
    <link href="/css/mmdi.css" type='text/css' rel='stylesheet'>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!--link href="{{URL::asset('/css/Bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{URL::asset('/css/Bootstrap/js/bootstrap.min.js')}}"></script-->

    @stack('head')

</head>
<body>

    <header>

    <div class="container center">
        <div class="row">
            <div class="col-sm-1 align-self-left">
                <!--a class="btn btn-info" href="{{ URL::previous() }}">back</a-->
            </div>
            <div class="col-sm-10 align-self-center">
               <img src='http://moramoradiseno.com/wp-content/uploads/2017/06/cropped-mm-diseno.001-2.png' style='width:300px' alt='MMDI Logo' class="center">

            </div>
        </div>
    </div>
    </header>

    @if(session('message'))
        <!--div class='alert'>{{ session('message') }}</div-->
    @endif

	<div class="container center">
        <div class="row">
            <div class="col-sm-12 align-self-center">
               <div class="navbar navbar-default center" role="navigation" id="navigation">
                    <div class="navbar-header">
                         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse center">
                        <ul class="nav navbar-nav center">
                            <li id="menu"><a href="/proyectos">Proyectos</a></li>
                            <li id="menu"><a href='/elementos'>BD Precios Unitarios</a></li>
                            <li id="menu"><a href='/clientes'>Clientes</a></li>
                            <li id="menu"><a href="/pagosClientes">Pagos Clientes</a></li>
                            <li id="menu"><a href='/cotizaciones'>Cotizaciones</a></li>
                            <li id="menu"><a href='/proveedores'>Proveedores</a></li>
                            <li id="menu"><a href="/pagosProveedores">Pagos Proveedores</a></li>
                            <li id="menu"><a href="/recursos">Recursos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.message')

    </div>

    <section>
        @yield('content')
    </section>

    <!--footer>
        &copy; {{ date('Y') }}
    </footer-->


    @stack('body')

</body>
</html>