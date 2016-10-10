@extends('layouts.master')


@section('content')
<div class="container-fluid">
<div class="raw">
<!-- Form -->
    <div class="search-bar" id="search-bar">
      <form action="" method="POST" id="search-form-bar" class="form-inline">
      {!! csrf_field() !!}
  		<div class="form-group">
  			<label class="sr-only" for="origin-input">Nhập địa điểm</label>
  			<div class="input-group">
		      <div class="input-group-addon" id="from-label">Đi</div>
		      <input type="text" class="form-control" name="origin-input" id="origin-input" placeholder="Nhập điểm đi">
		      <div class="input-group-addon"><i class="fa fa-times" aria-hidden="true"></i></div>
		      <input type="hidden" name="origin_place_id" id="origin_place_id">
		      <input type="hidden" name="origin_place_name" id="origin_place_name">
		    </div>
  			<div id="switch" class="form-control"><a href=""><i class="fa fa-exchange" aria-hidden="true"></i></a></div>
  		</div>
        <div class="form-group">
  			<label class="sr-only" for="destination-input">Nhập địa điểm</label>
  			<div class="input-group">
		      <div class="input-group-addon">Đến</div>
		      <input type="text" class="form-control" name="destination-input" id="destination-input" placeholder="Nhập điểm đi">
		      <div class="input-group-addon"><i class="fa fa-times" aria-hidden="true"></i></div>
		      <input type="hidden" name="destination_place_id" id="destination_place_id">
		      <input type="hidden" name="destination_place_name" id="destination_place_name">
		    </div>
  		</div>
      </form>
    </div>
    <!-- /.form -->

    <div id="map"></div>

    <div class="fixed list-result">
    	<div class="list-group">
		  <button type="button" class="list-group-item">
		  	<span class="badge"><i class="fa fa-plane" aria-hidden="true"></i></span>
		  	<h4>Bay từ Hà Nội</h2>
		  	<p>2 giờ 30 phút</p>
		  </button>
		  <button type="button" class="list-group-item">
		  	<span class="badge"><i class="fa fa-plane" aria-hidden="true"></i></span>
		  	<h4>Bay từ Hà Nội</h2>
		  	<p>2 giờ 30 phút</p>
		  </button>
		  <button type="button" class="list-group-item">
		  	<span class="badge"><i class="fa fa-plane" aria-hidden="true"></i></span>
		  	<h4>Bay từ Hà Nội</h2>
		  	<p>2 giờ 30 phút</p>
		  </button>
		  <button type="button" class="list-group-item">
		  	<span class="badge"><i class="fa fa-plane" aria-hidden="true"></i></span>
		  	<h4>Bay từ Hà Nội</h2>
		  	<p>2 giờ 30 phút</p>
		  </button>
		  <button type="button" class="list-group-item">
		  	<span class="badge"><i class="fa fa-plane" aria-hidden="true"></i></span>
		  	<h4>Bay từ Hà Nội</h2>
		  	<p>2 giờ 30 phút</p>
		  </button>
		  <button type="button" class="list-group-item">
		  	<span class="badge"><i class="fa fa-plane" aria-hidden="true"></i></span>
		  	<h4>Bay từ Hà Nội</h2>
		  	<p>2 giờ 30 phút</p>
		  </button>
		  <button type="button" class="list-group-item">
		  	<span class="badge"><i class="fa fa-plane" aria-hidden="true"></i></span>
		  	<h4>Bay từ Hà Nội</h2>
		  	<p>2 giờ 30 phút</p>
		  </button>
		  <button type="button" class="list-group-item">
		  	<span class="badge"><i class="fa fa-plane" aria-hidden="true"></i></span>
		  	<h4>Bay từ Hà Nội</h2>
		  	<p>2 giờ 30 phút</p>
		  </button>
		</div>
    </div>
</div>
</div>
    <script type="text/javascript">
    var origin_place_id_data = '{{$request->origin_place_id}}';
    var destination_place_id_data = '{{$request->destination_place_id}}';
    var origin_place_name = '{{$request->origin_place_name}}';
    var destination_place_name = '{{$request->destination_place_name}}';
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASxwmxpBVZk19s-L3z_64v3NAfHELNCLI&libraries=places&callback=initMap">
    </script>
@endsection
@section('footer')
@endsection