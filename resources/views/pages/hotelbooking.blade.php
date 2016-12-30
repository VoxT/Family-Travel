@extends('layouts.master')
@section('title', 'Trang Đặt Chỗ')

@section('content')
<div class="container" style="padding-top: 62px;">

	<div class="page-header">
        <h1 id="timeline">Đặt Phòng Khách Sạn</h1>
    </div>
	<ul class="timeline col-md-10 col-md-offset-1">
	    <li class="timeline-inverted">
		     <div class="timeline-badge hotel"><i class="fa fa-bed" aria-hidden="true"></i></div>
		     <div class="timeline-panel">
		        <div class="timeline-heading">
		        </div>
		        <div class="timeline-body" id="hotel-booking">
		          	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default  col-md-7">
					       	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							    <div class="panel-heading" role="tab" id="headingOne">
							      	<div class="row">
							          	<div class="col-md-8">
							          	@php
								          	$jsonToArray = (array) json_decode($hotelDetails);
								          	$input = $jsonToArray['input'];
								          	$hotel_details = $jsonToArray['hotel'];
							          	@endphp

							          		<h4>{{ $hotel_details->hotel->name }}</h4>
							          	</div>
							          	<div class="col-md-4">
								            <h4 style="color: #ffad00; text-align: right;"><div class="stars">
								            @for($i = 1; $i <= 5; $i++)
												@if($i <= $hotel_details->hotel->star_rating)
													<span><i class="fa fa-star" aria-hidden="true"></i></span>
												@else 
													<span><i class="fa fa-star-o" aria-hidden="true"></i></span>
												@endif
											@endfor
								            </div></h4>
								    	</div>
								    </div>
								    <div class="row">
							          <div class="col-md-8">
							          		<h4>Tổng giá <span>{{number_format($hotel_details->price_total,0,",",".")}}<sup>đ</sup></span> <span style="color: grey; font-size: 14px;">({{$input->rooms}} x {{$hotel_details->room->type_room}})</span></h4>
							          </div>
								      <div class="col-md-4"><h4 style="color: grey; text-align: right;">{{$hotel_details->reviews->reviews_count}} nhận xét</h4></div>
							        </div>
							    </div>
					        </a>
						    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						      <div class="panel-body">
						      	
							      <div class="details" data-target='@{{data-target}}'>
								       <div class="image-gallery">
								          <ul>
								            @foreach ($hotel_details->hotel->image_url as $i => $value)
								            	@if($i == 7) @break; @endif
											    <li data-toggle="modal" data-target="#imageModal"><a href="#myGallery" data-slide-to="{{$i}}"><img class="img-responsive first" src="http://{{$value->url}}" alt="{{$hotel_details->hotel->name}}"></a></li>
											@endforeach
								          <!--end of thumbnails-->
								          </ul>
								        </div>  
								        <div class="clearfix"> </div>
								      <div class="">
								          <ul class="nav nav-tabs">
								            <li class="active"><a data-toggle="tab" href="#home">Mô Tả</a></li>
								            <li><a data-toggle="tab" href="#menu1">Cơ Sở Vật Chất</a></li>
								            <li><a data-toggle="tab" href="#menu2">Nhận Xét</a></li>
								          </ul>
								        <div class="tab-content">
								          <div id="home" class="tab-pane fade in active">
								            <h3>Mô Tả</h3> 								            
								            <p style="padding-top: 10px;">Địa Chỉ: {{$hotel_details->hotel->address}}</p>
								            <p>{{$hotel_details->hotel->description}}</p>
								          </div>
								          <div id="menu1" class="tab-pane fade">
								            <h3>Cơ Sơ Vật Chất</h3>
								              @foreach($hotel_details->hotel->amenities as $i => $value) 
												@if (($i%2) == 0)
										            <div class="row">
												@endif
										             <div class="col-md-6">
										                <img src="{{$value->image_url}}">
										                <h5> {{$value->name}} </h5>
										                <p>
										        @foreach($value->amenities_details as $j => $cmt)
										        	{{ $cmt->name }} ,
										        @endforeach
										        </p> </div>
										        @if ((($i+1)%2) == 0)
										           </div>
												@endif 
											@endforeach
										    @if ((count($hotel_details->hotel->amenities))%2 != 0)
										        </div>
											@endif
								          </div>
								          <div id="menu2" class="tab-pane fade">
								            <h3>Nhận Xét</h3>
								            @if($hotel_details->reviews->reviews_count > 0)
									            @foreach($hotel_details->reviews->categories as $i => $value)
													@if (($i%2) == 0) 
												       <div class="row">
													@endif
												          <div class="col-md-6">
												          <span class="badge">{{ $value->score/10 }}</span>
												            <h5> {{$value->name}}</h5>
												            <p>
												    @foreach($value->entries as $j => $entries)
												    	{{$entries}} ,
												    @endforeach
												    </p> </div>
												    
												    @if ((($i + 1)%2) == 0) 
												        </div>
													@endif
												@endforeach
											    @if ((count($hotel_details->reviews->categories))%2 != 0)
											        </div>
												@endif
											@else <p style="text-align: center;"> Không có nhận xét nào cho khách sạn này. </p>
											@endif	
								          </div>
								        </div>
								      </div>
								    </div>
						      </div>
						   	</div>

						 </div>

					<form action="postHotel" method="post" id="postHotel" enctype='application/json'>
							 {{ csrf_field() }}
						<input type="hidden" name="hoteldetails" value="{{ $hotelDetails }}">
						
						<div class="col-md-5" style="padding-left: 30px;">
							<div class="form-group">
								<label for="full_name" class="control-label">Họ Tên</label>
								<div class="">
									<input class='form-control' data-type="input" type='text' name='full_name' id='full_name' value ='{{Auth::user()->full_name}}' required />
								</div>
							</div>
							<div class="form-group">
								<div class="form-check">
									<label>Giới tính:</label>
							      <label class="form-check-label">
							        <input type="radio" class="form-check-input" name="gender" id="optionsRadios1" value="male" required="">
							        Nam
							      </label> 
							      <label class="form-check-label" style="margin-left: 10px;">
							        <input type="radio" class="form-check-input" name="gender" id="optionsRadios2" value="female" required="">
							        Nữ
							      </label>
							    </div>
							</div>
							<div class="form-group">
								<label for="email" class="control-label">Email</label>
								<div class="">
									<input class='form-control' data-type="input" type='text' name='email' id='email' value ='{{Auth::user()->email}}' required />
								</div>
							</div>
							<div class="form-group">
								<label for="phone" class="control-label">Số Điện Thoại</label>
								<div class="">
									<input class='form-control' data-type="input" type='text' name='phone' id='phone' value ='{{Auth::user()->phone}}' required/>
								</div>
							</div>
							<div class="form-group">
								<label for="address" class="control-label">Địa Chỉ</label>
								<div class="">
									<input class='form-control' data-type="input" type='text' name='address' id='address' value ='{{Auth::user()->address}}' />
								</div>
							</div>
							<div class="form-group">
		                        <div class="book">
		                            <button type="submit" class="btn btn-primary col-md-12" id="book" onclick="$('#postHotel').attr('action', '/bookinghotel');">
		                                Đặt
		                            </button>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <div class="payment">
		                            <button type="submit" class="btn btn-primary col-md-12" id="payment">
		                                Đặt và Thanh Toán
		                            </button>
		                        </div>
		                    </div>
						</div>

					</form>
		      		</div>
		     	</div>
		     </div>
	   </li>
	</ul>
</div>
<div class="modal fade" id="imageModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">

      <!--begin carousel-->
        <div id="myGallery" class="carousel" data-interval="false">
          <div class="carousel-inner">
          @foreach($hotel_details->hotel->image_url as $i => $image)
            <div class="item {{!$i? 'active': ''}}"> <img src="http://{{$image->url}}" alt="{{$hotel_details->hotel->name}}" class="img-responsive"></div>
           @endforeach
          <!--end carousel-inner--></div>
          <!--Begin Previous and Next buttons-->
          <a class="left carousel-control" href="#myGallery" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myGallery" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span></a>
        <!--end carousel--></div>

      </div><!--end modal-content-->
  </div><!--end modal-dialoge-->
</div><!--end myModal-->


@endsection
@section('footer')
	@include('layouts.footer')
@endsection


@section('scripts')
  @parent


@endsection