<!DOCTYPE html>
<html>
<head>
    <title>
        @yield('title', 'MMDI Desarrollo Kokai Web')
    </title>

    <meta charset='utf-8'>
    <link href="/css/mmdi.css" type='text/css' rel='stylesheet'>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script-->
    <script src="{{URL::asset('/css/Bootstrap/js/bootstrap.min.js')}}"></script>

    <!--link href="{{URL::asset('/css/Bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{URL::asset('/css/Bootstrap/js/bootstrap.min.js')}}"></script-->

    @stack('head')

</head>
<body>

    <header>
        <div class="container center">
            <div class="row">
                <div class="col-sm-3 align-self-left">
                    <!--a class="btn btn-info" href="{{ URL::previous() }}">back</a-->
                </div>
                <div class="col-sm-6 align-self-center">
                   <img src='http://moramoradiseno.com/wp-content/uploads/2017/06/cropped-mm-diseno.001-2.png' style='width:300px' alt='MMDI Logo' class="center">
                </div>
                <div class="col-md-3">
                @if (Auth::check())
                        <!--form method='POST' id='logout' action='/logout'>
                            {{ csrf_field() }}
                            <a href='#' onClick='document.getElementById("logout").submit();'>Cerrar Sesión ()</a>
                        </form-->
                    @else
                        ¿Ya tienes una cuenta? <a href='/login'>Entra aquí...</a>
                    @endif
			    </div>
            </div>
        </div>
    </header>


    @if(session('message'))
        <!--div class='alert'>{{ session('message') }}</div-->
    @endif
    <div class="container center">
        @if (Auth::check())
            @include('layouts.menu')
        @endif
        @include('layouts.message')
    </div>

    <section>
        <div class="container center">
            <div class="row">
                <div class="col-sm-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>

    <!--footer>
        &copy; {{ date('Y') }}
    </footer-->


    @stack('body')

</body>
</html>