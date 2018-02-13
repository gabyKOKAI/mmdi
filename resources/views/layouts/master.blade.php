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