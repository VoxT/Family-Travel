@extends('layouts.master')


@section('content')
<div class="container-fluid">
<div class="raw">
<!-- Form -->
    <div class="search-bar" id="search-bar">
      <form action="" method="GET" id="search-form-bar" class="form-inline">
      {!! csrf_field() !!}
  		<div class="form-group">
  			<label class="sr-only" for="origin-input">Nhập địa điểm</label>
  			<div class="input-group">
		      <div class="input-group-addon" id="from-label">Đi</div>
		      <input type="text" class="form-control" name="originplace" id="origin-input" placeholder="Nhập điểm đi">
		      <div class="input-group-addon"><i class="fa fa-times" aria-hidden="true"></i></div>
		    </div>
  			<div id="switch" class="form-control"><i class="fa fa-exchange" aria-hidden="true"></i></div>
  		</div>
        <div class="form-group">
  			<label class="sr-only" for="destination-input">Nhập địa điểm</label>
  			<div class="input-group">
		      <div class="input-group-addon">Đến</div>
		      <input type="text" class="form-control" name="destinationplace" id="destination-input" placeholder="Nhập điểm đến">
		      <div class="input-group-addon"><i class="fa fa-times" aria-hidden="true"></i></div>
		    </div>
  		</div>
      </form>
    </div>
    <!-- /.form -->

    <div id="map"></div>
    <!-- results marker on map-->
    <div id="results" > </div>
    <div style="display: none">
        <div id="info-content" >
            <div class="row" >
               <div id="iw-icon"></div>
               <div id="iw-url" class="url_name"></div>
               <div id="iw-rating-row" > 
                   <p class="iw-rating"> Rating: <span id="iw-rating"></span></p>
               </div>
            </div>  
           
        </div>
    </div>    

    <div class="fixed list-result">
    	<div class="list-group">
		  <button type="button" class="list-group-item" id="plane"  data-toggle="modal" data-target="#planeModal">
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

	<!-- Modal -->
	<div class="modal fade" id="planeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
	        <h2 class="modal-title" id="planeModalLabel"><i class="fa fa-plane" aria-hidden="true"></i> Bay từ Hanoi đến Ho Chi Minh City</h2>
	      </div>
	      <div class="modal-body">
	      	<div class="result-list">
	      		<div class="loading">
	      			<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
	      			<p>Đang tìm kiếm ...</p>
	      		</div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary">Save changes</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
</div>

<script type="text/template" id="flightTemplate">
    <div class="result-item">
		<div class="item-details">
			@{{outbound}}
			@{{inbound}}
			<div class="item-details-footer">
				<a class="details-link" href=""><i class="fa fa-info-circle" aria-hidden="true"></i> Chi tiết</a>
				<a class="agent-links" href="">Jestar</a>
			</div>
		</div>
		<div class="item-summary">
			<div class="summany-details">1 người lớn | Economy</div>
			<div class="price-select-block">
				<div class="flight-price">@{{price}}vnđ</div>
				<a class="item-select-button" href="">Đặt Ngay <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
			</div>
		</div>
	</div>
</script>
<script type="text/template" id="flightItemTemplate">
	<div class="journey-row">
		<div class="journey-row-item">
			<div class="flight-logo">
				<img src="@{{ImageUrl}}" atl="@{{ImageName}}">
			</div>
			<div class="origin-place">
				<div class="journey-time">@{{Departure}}</div>
				<div class="journey-station">@{{NameOrigin}}</div>
			</div>
			<div class="stop-map">
				<div class="journey-duration">@{{Duration_h}} giờ : @{{Duration_m}} phút</div>
				<div class="journey-line"></div>
				<div class="journey-stop">Bay thẳng</div>
			</div>
			<div class="destination-place">
				<div class="journey-time">@{{Arrival}}</div>
				<div class="journey-station">@{{NameDestination}}</div>
			</div>
		</div>	
	</div>
</script>
	<script type="text/javascript">
		// var pac_width = $('.input-group').width();
		// $(".pac-container").css("width", "325px !important");
	</script>
    <script type="text/javascript">
    var origin_place_name = '{{$request["originplace"]}}';
    var destination_place_name = '{{$request["destinationplace"]}}';
    $('#switch').click(function(){
    	var originInput = $('#origin-input').val();
    	$('#origin-input').val($('#destination-input').val());
    	$('#destination-input').val(originInput);
    });
	$('#planeModal').on('hide.bs.modal', function (e) {

	});
    </script>

	<script src="{{ elixir('js/mapScript.js') }}"></script>	
	<script src="{{ elixir('js/apiScript.js') }}"></script>	
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHQZWI0R8e412mvB1k44OOigCcPe5FTh0&libraries=places&callback=initMap">
    </script>
@endsection

@section('footer')
@endsection