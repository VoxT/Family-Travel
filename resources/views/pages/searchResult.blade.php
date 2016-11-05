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
               <p class="views"> Cảnh đẹp, nơi giải trí ,....</p>
               <div> <hr/></div>
               <div id="iw-rating-row" > 
                   <p class="iw-rating"> Đánh giá: <span id="iw-rating"></span></p>

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
		  <button type="button" class="list-group-item" id="car" data-toggle="modal" data-target="#carModal">
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



<!-- Flight Modal -->
<div class="modal fadeLeft fade" id="planeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-label="Close" class="closeButton"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
        <h2 class="modal-title" id="planeModalLabel"><i class="fa fa-plane" aria-hidden="true"></i> Bay từ Hanoi đến Ho Chi Minh City</h2>
        <div class="flight-form-modal">
    		<button type="button" class="depart" id="depart"><i class="fa fa-calendar" aria-hidden="true"></i>
        		 <span>27/10/2016</span>
        		<input type="date" name="outbounddate" id="outbounddate">
    		</button>
    		<button type="button" class="arrival" id="arrival"><i class="fa fa-calendar" aria-hidden="true"></i> 
        		<span> --/--/---- </span>
        		<input type="date" name="inbounddate" id="inbounddate">
    		</button>
    		<button type="button" class="moreInfo" id="moreInfo">1 người, ghế thương gia <span class="caret"></span></button>
    		<button type="button" class="flight-search btn-search" id="flight-search">Tìm Kiếm</button>
    		<div class="popover-flight container" style="display: none;">
        		<div class="form-horizontal">
        			<div class="form-group">
					  <label for="adults">Người lớn</label>
					  <select class="form-control" id="adults">
					    <option>1</option>
					    <option>2</option>
					    <option>3</option>
					    <option>4</option>
					  </select>
					</div>
        			<div class="form-group">
					  <label for="childrens">Trẻ trên 12</label>
					  <select class="form-control" id="childrens">
					    <option>1</option>
					    <option>2</option>
					    <option>3</option>
					    <option>4</option>
					  </select>
					</div>
        			<div class="form-group">
					  <label for="kid">Trẻ dưới 12</label>
					  <select class="form-control" id="kid">
					    <option>1</option>
					    <option>2</option>
					    <option>3</option>
					    <option>4</option>
					  </select>
					</div>
        		</div>
        		<div class="cabinclass">
        			<h4>Loại Ghế</h4>
        			<label class="form-check-label col-md-6">
			            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1">
			            Thương gia
			         </label>
        			<label class="form-check-label col-md-6">
		            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
		            Thương gia
		         </label>
        			<label class="form-check-label col-md-6">
			            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" >
			            Thương gia
			         </label>
        			<label class="form-check-label col-md-6">
		            <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" >
		            Thương gia
		         </label>
        		</div>
        		<div class="clearfix"></div>
        	</div>
        </div>
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
      </div>
    </div>
  </div>
</div>
<!-- Modal flight details -->
<div class="modal fade" id="flightdetailsmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3>Thông Tin Chuyến Bay</h3>
      </div>
      <div class="modal-body">
        <div class="details">
        	<h2 class="details-title">Hà Nội tới Thành Phố Hồ Chí Minh</h2>
        	<div class="details-row">
        		<h3 class="row-title"><b>Lượt đi</b> 29/07/2016</h3>
        		<div class="details-content">
        			<div class="content-info">
        				<div class="info-cell">
        					<h4>Hà Nội</h4>
        					<h5>20:00</h5>
        				</div>
        				<div class="info-cell">
        					<span><i class="fa fa-plane" aria-hidden="true" style="transform: rotate(45deg); margin-left: 10px"></i></span>
        					<h4>Hà Nội</h4>
        					<h5>20:00</h5>        					
        				</div>
        				<div class="info-cell">
        					<h5>Thời gian bay</h5>
        					<h5>20:00</h5>        					
        				</div>
        			</div>
		        	<div class="carrier">
		        		<div class="flight-logo">
							<img src="http://s1.apideeplink.com/images/airlines/JQ.png" atl="Jetstar">
						</div>
		        		<span>JetStart - J12355</span>
		        	</div>
        		</div>
        		<div class="stop-time">Stopover: <strong>Taipei, Taiwan</strong> <span>3hrs&nbsp;20min</span></div>
        	</div>
        	<div class="details-row">
        		<h3 class="row-title"><b>Lượt về</b> 29/07/2016</h3>
        		<div class="details-content">
        			<div class="content-info">
        				<div class="info-cell">
        					<h4>Hà Nội</h4>
        					<h5>20:00</h5>
        				</div>
        				<div class="info-cell">
        					<span><i class="fa fa-plane" aria-hidden="true" style="transform: rotate(45deg); margin-left: 10px"></i></span>
        					<h4>Hồ Chí Minh</h4>
        					<h5>20:00</h5>        					
        				</div>
        				<div class="info-cell">
        					<h5>Thời gian bay</h5>
        					<h5>21:00</h5>  	
        				</div>
        			</div>
		        	<div class="carrier">
		        		<div class="flight-logo">
							<img src="http://s1.apideeplink.com/images/airlines/JQ.png" atl="Jetstar">
						</div>
		        		<span>JetStart - J12355</span>
		        	</div>
        		</div>
        	</div>
        </div>
        <div class="summary">
        	<h5>2 Người | Ghế Thương Gia</h5>
        	<div class="best-price">
        		<p>JetStart</p>
        		<h3>1.200.000<sup>đ</sup></h3>
        		<p>(Tổng giá 1.300.000<sup>đ</sup>)</p>
        		<a class="item-select-button">Đặt Ngay</a>
        	</div>
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<!-- Car Model -->
<div class="modal fadeLeft fade" id="carModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-label="Close" class="closeButton"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
        <h2 class="modal-title" id="modalLabel"><i class="fa fa-plane" aria-hidden="true"></i> Thuê xe tại Ho Chi Minh City</h2>
        <div class="flight-form-modal">
    		<button type="button" class="depart" id="pickupdate"><i class="fa fa-calendar" aria-hidden="true"></i>
        		 <span>27/10/2016</span>
        		<input type="date" name="pickupdate" id="pickupdate-input">
    		</button>
			<i class="fa fa-clock-o" aria-hidden="true"></i>
    		<select class="picktime" id="pickuptime">
			    <option>1:00</option>
			    <option>1:30</option>
			    <option>3</option>
			    <option>4</option>
			</select>
    		<button type="button" class="arrival" id="dropoffdate"><i class="fa fa-calendar" aria-hidden="true"></i> 
        		<span> 27/10/2016 </span>
        		<input type="date" name="dropoffdate" id="dropoffdate-input">
    		</button>
			<i class="fa fa-clock-o" aria-hidden="true"></i>
    		<select class="picktime" id="pickuptime">
			    <option>1</option>
			    <option>2</option>
			    <option>3</option>
			    <option>4</option>
			</select>
        	<input type="date" name="outbounddate" id="pickupdatetime">
        	<input type="date" name="outbounddate" id="dropoffdatetime">
    		<button type="button" class="flight-search btn-search" id="car-search">Tìm Kiếm</button>
        </div>
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
      </div>
    </div>
  </div>
</div>

<form action="/booking/flight" method="post" target="_blank" id="flightbook" enctype='application/json'>
	 {{ csrf_field() }}
	<input type="hidden" name="flightdetails" value="">
</form>
<!-- --------------------------------------------------- -->
<script type="text/template" id="itemsTemplate">
    <div class="result-item">
		<div class="item-details">
			@{{outbound}}
			@{{inbound}}
			<div class="item-details-footer">
				<a class="details-link" href="#openmodel"><i class="fa fa-info-circle" aria-hidden="true"></i> Chi tiết</a>
			</div>
		</div>
		<div class="item-summary">
			<div class="summary-details">1 người lớn | Economy</div>
			<div class="price-select-block">
				<div class="flight-price"><span>@{{price}}</span><sup>đ</sup></div>
				<a class="item-select-button" href="#">Đặt Ngay <i class="fa fa-plane" aria-hidden="true" style="transform: rotate(0deg); margin-left: 10px"></i></a>
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
				<div class="journey-line">
					<span class="line-stop">
						<span class="stop-dot" data-powertip="Danang"></span>
					</span>
				</div>
				<div class="journey-stop">Bay thẳng</div>
			</div>
			<div class="destination-place">
				<div class="journey-time">@{{Arrival}}</div>
				<div class="journey-station">@{{NameDestination}}</div>
			</div>
		</div>	
	</div>
</script>

<script type="text/template" id="carItemTemplate">
	<div class="result-item">
		<div class="car-details">
			<div class="car-logo">
				<p><strong>@{{vehicle}}</strong></p>
				<img src="@{{image_url}}" atl="Car image">
			</div>
			<div class="item-car-details">
				<p class="car-class">@{{car_class_name}}</p>
				<div class="clearfix">
					<ul class="strong">
						<li>@{{seats}} Chỗ <em>-</em></li>
						<li>@{{doors}} Cửa <em>-</em></li>
						<li>Đựng được @{{bags}} túi</li>
					</ul><br/>
					<ul>
						<li><i class="fa fa-check @{{air_conditioning_icon}}" aria-hidden="true"></i> Điều hoà không khí</li>
						<li><i class="fa @{{manual_icon}}" aria-hidden="true"></i> Số tự động</li>
						<li><i class="fa @{{mandatory_chauffeur_icon}}" aria-hidden="true"></i> Tài xế</li>
					</ul>
				</div>
				<div class="free-group clearfix">
					<div class="pickup">
						<span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
						<span>Điểm nhận xe:</span>
						<span>@{{pick_up_address}}</span>
					</div>
				</div>
				<div class="free-group">
					<ul>
						<li><i class="fa @{{free_cancellation_icon}}" aria-hidden="true"></i> Miễn phí huỷ đặt</li>
						<li><i class="fa @{{free_breakdown_assistance_icon}}" aria-hidden="true"></i> Hỗ trợ hỏng xe</li>
						<li><i class="fa @{{free_collision_waiver_insurance_icon}}" aria-hidden="true"></i> Bảo hiểm tai nạn</li>
						<li><i class="fa @{{theft_protection_insurance_icon}}" aria-hidden="true"></i> Bảo hiểm chống trộm</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="item-summary">
			<div class="fuel">
				<p>@{{fuel_policy}} Đầy bình</p>
			</div>
			<div class="price-select-block">
				<p>Tổng giá:</p>
				<div class="flight-price">@{{price_all_days}}<sup>đ</sup></div>
				<a class="item-select-button" href="">Đặt Ngay <i class="fa fa-car" aria-hidden="true" style="margin-left: 5px;"></i></a>
			</div>
		</div>
	</div>	
</script>
	<script type="text/javascript">
		// var pac_width = $('.input-group').width();
		// $(".pac-container").css("width", "325px !important");
	</script>
    <script type="text/javascript">
    var $request = JSON.parse('{{ $request}}'.replace(/&quot;/g,'"'));
    
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
	<script src="{{ elixir('js/homeScript.js') }}"></script>
	<script src="{{ elixir('js/searchResult.js') }}"></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHQZWI0R8e412mvB1k44OOigCcPe5FTh0&callback=initMap&language=vi&region=VN&libraries=places">
    </script>
@endsection

@section('footer')
@endsection