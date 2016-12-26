<!DOCTYPE html> 
<html> 
	<head> 
		<title>@yield('title')</title> 
		<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- CSRF Token --> 
		<meta name="csrf-token" content="{{ csrf_token() }}"> 
		
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
		<link rel="stylesheet" href="{{ elixir('css/app.css') }}"> 
		<link rel="stylesheet" type="text/css" href="{{ elixir('css/custom.min.css') }}"> 
	</head> 
	<body class="nav-md"> 
		<div class="container body"> 
			<div class="main-container"> 
				@yield('sidebar') 
				@yield('content')
			 </div> 
		 </div> 

		<script src="{{ elixir('js/app.js') }}"></script> 
		<script src="{{ elixir('js/custom.min.js') }}"></script> 
		<script type="text/javascript">
			$('#datatable').DataTable();
		</script>
	 </body> 
 </html>