@extends('layouts.master')
@section('title', 'Trang Đặt Chỗ')

@section('content')
<div class="container" style="padding-top: 62px;">

	<div class="page-header">
        <h1 id="timeline">Đặt Vé Máy Bay</h1>
    </div>
	<ul class="timeline col-md-10 col-md-offset-1">
	    <li class="timeline-inverted">
		     <div class="timeline-badge flight"><i class="fa fa-plane" aria-hidden="true"></i></div>
		     <div class="timeline-panel">
		        <div class="timeline-heading">
		        </div>
		        <div class="timeline-body" id="flight-booking">
		          	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default  col-md-7">
					       	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							    <div class="panel-heading" role="tab" id="headingOne">
							      <h4 class="panel-title clearfix">
							          <div class="col-md-12">
							          		<h4>Bay từ Hà Nội tới Thành Phố Hồ Chí Minh</h4>
							          </div>
							          <div class="col-md-12">
							          		<h4>Tổng giá <span>12.000.000<sup>đ</sup></span></h4>
							          </div>
							      </h4>
							    </div>
					        </a>
						    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						      <div class="panel-body">
							    <div class="details" id="flightdetailsmodal">
							    	<br/>
									<div class="details-row">
										<h3 class="row-title"><b>Lượt đi</b> 29/07/2016</h3>
										@foreach($flightDetails[0]->outbound as $flight)
										<div class="details-content">
											<div class="content-info">
												<div class="info-cell">
													<h4>{{$flight->origin}}</h4>
													<h5>{{$flight->depart}}</h5>
												</div>
												<div class="info-cell">
													<span><i class="fa fa-plane" aria-hidden="true" style="transform: rotate(45deg); margin-left: 10px"></i></span>
													<h4>{{$flight->destination}}</h4>
													<h5>{{$flight->arrival}}</h5>        					
												</div>
												<div class="info-cell">
													<h5>Thời gian bay</h5>
													<h5>20:00</h5>        					
												</div>
											</div>
								        	<div class="carrier">
								        		<div class="flight-logo">
													<img src="{{$flight->carrier_logo}}" atl="Jetstar">
												</div>
								        		<span>{{$flight->carrier_name}}</span>
								        	</div>
										</div>
										@endforeach
										<div class="stop-time">Stopover: <strong>Taipei, Taiwan</strong> <span>3hrs&nbsp;20min</span></div>
									</div>

							    	<br/>
									
									<div class="details-row">
										<h3 class="row-title"><b>Lượt về</b> 29/07/2016</h3>
										@foreach($flightDetails[1]->inbound as $flight)
										<div class="details-content">
											<div class="content-info">
												<div class="info-cell">
													<h4>{{$flight->origin}}</h4>
													<h5>{{$flight->depart}}</h5>
												</div>
												<div class="info-cell">
													<span><i class="fa fa-plane" aria-hidden="true" style="transform: rotate(45deg); margin-left: 10px"></i></span>
													<h4>{{$flight->destination}}</h4>
													<h5>{{$flight->arrival}}</h5>        					
												</div>
												<div class="info-cell">
													<h5>Thời gian bay</h5>
													<h5>20:00</h5>        					
												</div>
											</div>
								        	<div class="carrier">
								        		<div class="flight-logo">
													<img src="{{$flight->carrier_logo}}" atl="Jetstar">
												</div>
								        		<span>{{$flight->carrier_name}}</span>
								        	</div>
										</div>
										@endforeach
										<div class="stop-time">Stopover: <strong>Taipei, Taiwan</strong> <span>3hrs&nbsp;20min</span></div>
									</div>
								</div>
						      </div>
						   	</div>

						 </div>

					<form action="/booking/postFlight" method="post" id="flightbook" enctype='application/json'>
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


@endsection
@section('footer')
	@include('layouts.footer')
@endsection