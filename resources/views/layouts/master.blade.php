<!DOCTYPE html>
<html>
<head>
    <title>
        @yield('title', 'MMDI')
    </title>

    <meta charset='utf-8'>
    <link href="/css/mmdi.css" type='text/css' rel='stylesheet'>

    @stack('head')

</head>
<body>

    <header>
        <img
        src='http://moramoradiseno.com/wp-content/uploads/2017/06/cropped-mm-diseno.001-2.png'
        style='width:300px'
        alt='MMDI Logo' class="center">
    </header>

	
	<div class="navbar navbar-default" role="navigation" id="navigation">
	        <div class="navbar-header">
    		     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        			<span class="sr-only">Toggle navigation</span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
          		</button>
          	</div>
        	<div class="collapse navbar-collapse">
        		<ul class="nav navbar-nav">
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
			<hr/> <!--	White line -->
     </div>
	
	@if(count($errors) > 0)
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
	@endif

    <section>
        @yield('content')
    </section>

    <footer>
        &copy; {{ date('Y') }}
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    @stack('body')

</body>
</html>