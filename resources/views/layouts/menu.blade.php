<div class="container center">
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
                        <li class="dropdown" id="menu">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Configuraciones
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <li><a href="/elementos">Base de Datos (PU)</a></li>
                              <li><a href="/elemento/-1">Nuevo Elemento</a></li>
                              <li><a href="/proyecto/-1">Nuevo Proyecto</a></li>
                              <li><a href="/cliente/-1">Nuevo Cliente</a></li>
                              <!--li><a href="/pagoCliente/-1">Nuevo Pago Cliente</a></li-->
                              <li><a href="/cotizacion/-1">Nueva CXP</a></li>
                              <li><a href="/proveedor/-1">Nuevo Proveedor</a></li>
                              <!--li><a href="/pagoProveedor/-1">Nuevo Pago Proveedore</a></li-->
                              <li><a href="/movimiento/-1">Nuevo Movimiento</a></li>
                            </ul>
                        </li>
                        <li class="dropdown" id="menu">
                            <a href="/proyectos">Proyectos</a>
                        </li>
                        <li class="dropdown" id="menu">
                            <a href="/cotizaciones">CXP</a>
                        </li>
                        <li class="dropdown" id="menu">
                            <a href="/clientes">Clientes</a>
                        </li>
                        <li class="dropdown" id="menu">
                            <a href="/proveedores">Proveedores</a>
                        </li>
                        <li class="dropdown" id="menu">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Pagos
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <li><a href="/pagosClientes">Pagos Clientes</a></li>
                              <li><a href="/pagosProveedores">Pagos Proveedores</a></li>

                            </ul>
                        </li>
                        <li class="dropdown" id="menu">
                            <a href="/recursos">Recursos</a>
                        </li>
                        <li class="dropdown" id="menu">
                            <a href="/cuentas">Cuentas</a>
                        </li>
                        <li class="dropdown" id="menu">
                            <a href="/movimientos">Movimientos</a>
                        </li>
                        <!--li class="dropdown" id="menu">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Movimientos
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <li><a href="/recursos">Lista de Recursos</a></li>
                              <li><a href="/cuentas">Lista de Cuentas</a></li>
                              <li><a href="/movimientos">Lista Movimientos</a></li>
                              <li><a href="/movimiento/-1">Nuevo Movimiento</a></li>
                            </ul>
                        </li-->
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Salir
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                    <li><a href="/registraUsuario">Registrar Usuario</a></li>
                                    <li><a href="/usuarios">Usuarios</a></li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>