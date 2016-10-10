@extends('layouts.master')


@section('content')
      <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="http://content.skyscnr.com/5aec0fafb28897e4c9deb1a0b1855d00/BKKT-banner.jpg?resize=2000px:530px&quality=90" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Example headline.</h1>
              <p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="http://content.skyscnr.com/b93ae449bc5af27d7e9d229542b9e148/SFOA-banner.jpg?resize=2000px:530px&quality=90" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Another example headline.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="http://content.skyscnr.com/1e3e39c36183fd8ea94cec3e9332469d/PARI-banner.jpg?resize=2000px:530px&quality=90" alt="Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>One more for good measure.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="banner-arrow-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="banner-arrow-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->

    <!-- Form -->
<!--     <div class="container testform">
      <form action="" method="POST" id="search-form">
      {!! csrf_field() !!}
          <label for="origin-input">Origin Place:</label>
          <input id="origin-input" class="form-control" name="origin_place" type="text"></input>
          <input type="hidden" name="origin_place_id" id="origin_place_id">
          <input type="hidden" name="origin_place_name" id="origin_place_name">
          <label for="destination-input">Destination Place:</label>
          <input id="destination-input" class="form-control" name="destination_place" type="text"></input>
          <input type="hidden" name="destination_place_id" id="destination_place_id">
          <input type="hidden" name="destination_place_name" id="destination_place_name">
          <input type="submit" class="form-control"/>
      </form>
    </div> -->
    <!-- /.form -->

    <div class="container form-search">
        <div class="col-md-9 col-md-offset-1 col-centered">
         	<div class="raw">
	         	<div class="col-md-12">
					<div class="form-bar">
						<p class="form-bar-tab">Tìm kiếm thông tin chuyến đi</p>
					</div>
				</div>

      			<form action="" method="POST" id="search-form">
     			 {!! csrf_field() !!}
					<div class="col-md-4" id="input-group" >
			          	<div class="input-group">
					      <input type="text" class="form-control" name="origin-input" id="origin-input" placeholder="Nhập điểm đi">
					      <input type="hidden" name="origin_place_id" id="origin_place_id">
					      <input type="hidden" name="origin_place_name" id="origin_place_name">
					    </div>
					    <div class="input-group">
					      <input type="text" class="form-control" name="destination-input" id="destination-input" placeholder="Nhập điểm đi">
					      <input type="hidden" name="destination_place_id" id="destination_place_id">
					      <input type="hidden" name="destination_place_name" id="destination_place_name">
					    </div>
					    <input type="submit" value="submit" name="">
					</div>
				</form>
          	</div>
        </div>
    </div>

    <script type="text/javascript">
       
    </script>

    <script type="text/javascript">
      $(document).ready(function () {

        $('#search-form').validate({ // initialize the plugin
            rules: {
                origin_place: {
                    required: true
                },
                destination_place: {
                    required: true
                }
            },
            submitHandler: function(form) {
                $("#search-form").attr("action", "/search/" + $('#origin_place_name').val().replace(/ /g,"-") + "/" + $('#destination_place_name').val().replace(/ /g,"-"));
                form.submit();
              }
        });
    });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASxwmxpBVZk19s-L3z_64v3NAfHELNCLI&libraries=places&callback=autocompletePlace"
        async defer></script>
@endsection