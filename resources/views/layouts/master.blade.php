<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
	<link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ elixir('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ elixir('css/map-icons.css') }}">
    <script src="{{ elixir('js/app.js') }}"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>

	@section('sidebar')
        @include('layouts.sidebar')
    @show

    <section>
        @yield('content')
    </section>

    @include('auth.login')
    @include('auth.register')

  
    @section('footer')
            This is the master footer.
    @show

    @section('scripts')
    @show
</body>

</html>