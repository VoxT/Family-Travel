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
							          	<div class="col-md-6">
							          		<h4>{{$hotelDetails['hotel']->name}}</h4>
							          	</div>
							          	<div class="col-md-6">
								            <h4 style="color: #ffad00; text-align: right;"><div class="stars">
								            @for ($i = 0; $i < 5; $i++)
								              	@if((($hotelDetails['hotel']->popularity - 20*$i)/20) >= 1)
													<span><i class="fa fa-star" aria-hidden="true"></i></span>
												@elseif((($hotelDetails['hotel']->popularity - 20*$i)/20) >= 0.5)
													<span><i class="fa fa-star-half-o" aria-hidden="true"></i></span>
												@else 
													<span><i class="fa fa-star-o" aria-hidden="true"></i></span>
												@endif
											@endfor
								            </div></h4>
								    	</div>
								    </div>
								    <div class="row">
							          <div class="col-md-6">
							          		<h4>Tổng giá <span>{{number_format($hotelDetails['price_total'],0,",",".")}}<sup>đ</sup></span></h4>
							          </div>
								      <div class="col-md-6"><h4 style="color: grey; text-align: right;">{{$hotelDetails['reviews']->reviews_count}} nhận xét</h4></div>
							        </div>
							    </div>
					        </a>
						    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						      <div class="panel-body">
							      <div class="details" data-target='@{{data-target}}'>
								       <div class="image-gallery">
								          <ul>
								            @foreach ($hotelDetails['hotel']->image_url as $i => $value)
								            	@if($i == 7) @break; @endif
											    <li data-toggle="modal" data-target="#imageModal"><a href="#myGallery" data-slide-to="{{$i}}"><img class="img-responsive first" src="http://{{$value->url}}" alt="{{$hotelDetails['hotel']->name}}"></a></li>
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
								            <p style="padding-top: 10px;">Địa Chỉ: {{$hotelDetails['hotel']->address}}</p>
								            <p>{{$hotelDetails['hotel']->description}}</p>
								          </div>
								          <div id="menu1" class="tab-pane fade">
								            <h3>Cơ Sơ Vật Chất</h3>
								              @foreach($hotelDetails['hotel']->amenities as $i => $value) 
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
										    @if ((count($hotelDetails['hotel']->amenities))%2 != 0)
										        </div>
											@endif
								          </div>
								          <div id="menu2" class="tab-pane fade">
								            <h3>Nhận Xét</h3>
								            @foreach($hotelDetails['reviews']->categories as $i => $value)
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
										    @if ((count($hotelDetails['reviews']->categories))%2 != 0)
										        </div>
											@endif
								          </div>
								        </div>
								      </div>
								    </div>
						      </div>
						   	</div>

						 </div>

					<form action="/booking/postHotel" method="post" enctype='application/json'>
							 {{ csrf_field() }}
							<input type="hidden" name="flightdetails" value="">
						
						<div class="col-md-5" style="padding-left: 30px;">
							<div class="form-group">
								<label for="full_name" class="control-label">Họ Tên</label>
								<div class="">
									<input class='form-control' data-type="input" type='text' name='full_name' id='full_name' value ='{{Auth::user()->full_name}}' required />
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
		                        <div class="">
		                            <button type="submit" class="btn btn-primary col-md-12" id="book">
		                                Giữ Chỗ
		                            </button>
		                        </div>
		                    </div>
							<div class="form-group">
		                        <div class="">
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
          @foreach($hotelDetails['hotel']->image_url as $i => $image)
            <div class="item {{!$i? 'active': ''}}"> <img src="http://{{$image->url}}" alt="{{$hotelDetails['hotel']->name}}" class="img-responsive"></div>
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