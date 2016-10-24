<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ elixir('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ elixir('css/map-icons.css') }}">
      <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="{{ elixir('js/app.js') }}"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
</head>
<body>

	@section('sidebar')
        @include('layouts.sidebar')
    @show

    <section>
        @yield('content')

        <script src="{{ elixir('js/script.js') }}"></script>
    </section>

    @section('footer')
            This is the master footer.
    @show

</body>

</html>