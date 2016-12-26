var elixir = require('laravel-elixir');

var bowerDir ='vendor/bower/';


elixir(function(mix) {
	mix .copy( bowerDir + 'animate.css/animate.css', 'resources/assets/less/animate')
		.copy( bowerDir + 'bootstrap/less/**', 'resources/assets/less/bootstrap')
		.copy( bowerDir + 'bootstrap/dist/fonts/**', 'public/build/fonts')
		.copy( bowerDir + 'bootstrap/dist/js/bootstrap.min.js', 'resources/assets/js')
		.copy( bowerDir + 'jquery/dist/jquery.js', 'resources/assets/js')
		.copy( bowerDir + 'font-awesome/less/**', 'resources/assets/less/fontawesome')
		.copy( bowerDir + 'font-awesome/fonts', 'public/build/fonts')
		.copy( bowerDir + 'datatables.net/js/jquery.dataTables.min.js', 'resources/assets/js');

	mix.less(['app.less']);

	mix.scripts([
		    'jquery.js',
		    'jquery.dataTables.min.js',
      		'bootstrap.js',
      		'app.js'
		], 'public/js/app.js');

	 mix.version(['css/app.css', 'js/app.js']);

	 mix.browserSync({
        proxy: 'familytravel.com'
    });
});