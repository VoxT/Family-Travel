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
		    </div>
  			<div id="switch" class="form-control"><a href=""><i class="fa fa-exchange" aria-hidden="true"></i></a></div>
  		</div>
        <div class="form-group">
  			<label class="sr-only" for="destination-input">Nhập địa điểm</label>
  			<div class="input-group">
		      <div class="input-group-addon">Đến</div>
		      <input type="text" class="form-control" name="destination-input" id="destination-input" placeholder="Nhập điểm đến">
		      <div class="input-group-addon"><i class="fa fa-times" aria-hidden="true"></i></div>
		    </div>
  		</div>
      </form>
    </div>
    <!-- /.form -->

    <div id="map"></div>

    <div class="fixed list-result">
    	<div class="list-group">
		  <button type="button" class="list-group-item" id="plane">
		  	<span class="badge plane"><i class="fa fa-plane" aria-hidden="true"></i></span>
		  	<span class="chevron-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
		  	<h4>Bay từ Hà Nội</h2>
		  	<p>2 giờ 30 phút</p>
		  	<span class="price-right">78$ - 98$</span>
		  </button>
		  <button type="button" class="list-group-item" id="hotel">
		  	<span class="badge hotel"><i class="fa fa-bed" aria-hidden="true"></i></span>
		  	<span class="chevron-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
		  	<h4>Đặt khách sạn tại Hồ Chí Minh</h2>
		  	<p>Theo giá hợp lý nhất</p>
		  </button>
		  <button type="button" class="list-group-item" id="car">
		  	<span class="badge car"><i class="fa fa-car" aria-hidden="true"></i></i></span>
		  	<span class="chevron-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
		  	<h4>Thuê xe tại Hồ Chí Minh</h2>
		  	<p>Theo giá hợp lý nhất</p>
		  </button>
		  <button type="button" class="list-group-item" id="things">
		  	<span class="badge things"><i class="fa fa-university" aria-hidden="true"></i></i></span>
		  	<span class="chevron-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
		  	<h4>Địa điểm vui chơi tại Hồ Chí Minh</h2>
		  	<p>Những địa điểm hấp dẫn nhất</p>
		  </button>
		</div>
    </div>
</div>
</div>
	<script type="text/javascript">
		// var pac_width = $('.input-group').width();
		// $(".pac-container").css("width", "325px !important");
	</script>
    <script type="text/javascript">
    var origin_place_name = '{{$request["origin-input"]}}';
    var destination_place_name = '{{$request["destination-input"]}}';
    
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHQZWI0R8e412mvB1k44OOigCcPe5FTh0&libraries=places&callback=initMap">
    </script>
@endsection
@section('footer')
@endsection