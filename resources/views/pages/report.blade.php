@extends('layouts.master')
@section('title', 'Tổng hợp chuyến đi')

@section('content')

@php
	$flight_round = json_decode(json_encode($data['flights']));
	$hotels = json_decode(json_encode($data['hotels']));
	$cars = json_decode(json_encode($data['cars']));
@endphp
<div class="container" id="report" style="padding-top: 62px;">

	<div class="page-header">
        <h1 id="timeline">Tổng Hợp Chuyến Đi</h1>
    </div>
	<ul class="timeline col-md-12">
		@if(count($flight_round) > 0)
	    <li class="timeline-inverted">
		     <div class="timeline-badge flight"><i class="fa fa-plane" aria-hidden="true"></i></div>
		     <div class="timeline-panel">
		        <div class="timeline-heading"></div>

		        <div class="timeline-body">
					<div class="panel panel-default">
				       	<a role="button" data-toggle="collapse" data-parent="#report-list" href="#collapse-flight" aria-expanded="true" aria-controls="collapseOne">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title clearfix">
						          <div class="col-md-12">
						          		<h4>{{$flight_round[0]->Outbound[0]->originName}} - {{$flight_round[0]->Outbound[count($flight_round[0]->Outbound) - 1]->destinationName}}</h4>
						          </div>
						      </h4>
						    </div>
				        </a>

					    <div id="collapse-flight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					      <div class="panel-body">
					          	<div class="panel-group" id="accordion-flight" role="tablist" aria-multiselectable="true">
								@foreach($flight_round as $key => $flights)
									<div class="panel panel-default col-md-12">
								       	<a role="button" data-toggle="collapse" data-parent="#accordion-flight" href="#collapse-flight-{{$key}}" aria-expanded="true" aria-controls="collapseOne">
										    <div class="panel-heading" role="tab" id="headingOne">
										      	<div class="row">
										          <div class="col-md-12">
										          		<h4>{{$flights->Outbound[0]->originName}} - {{$flights->Outbound[count($flights->Outbound) - 1]->destinationName}}</h4>
										          </div>
										          <div class="col-md-12">
										          		<h4>Tổng giá <span>{{number_format($flights->Round->price,0,",",".")}}<sup>đ</sup></span></h4>
										          </div>
										         </div>
										    </div>
								        </a>

									    <div id="collapse-flight-{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
									      <div class="panel-body">
									      	<div class="col-md-8">
											    <div class="details" id="flightdetailsmodal">
													<div class="details-row">
														<h3 class="row-title"><b>Lượt đi</b> {{$flights->Outbound[0]->departureDate}}</h3>
														@php ( $oSegment = $flights->Outbound)
														@foreach($oSegment as $i => $flight)
														<div class="details-content">
															<div class="content-info">
																<div class="info-cell">
																	<h4>{{$flight->originName}}</h4>
				            										<h5 class="hop-location">{{$flight->originCode}}</h5>
																	<h5>{{$flight->departureTime}}</h5>
																</div>
																<div class="info-cell">
																	<span><i class="fa fa-plane" aria-hidden="true" style="transform: rotate(45deg); margin-left: 10px"></i></span>
																	<h4>{{$flight->destinationName}}</h4>
																	<h5 class="hop-location">{{$flight->destinationCode}}</h5>
																	<h5>{{$flight->arrivalTime}}</h5>        					
																</div>
																<div class="info-cell">
																	<h5>Thời gian bay</h5>
																	<h5>{{$flight->duration_h}}  giờ :  {{$flight->duration_m}}  phút</h5>        					
																</div>
															</div>
												        	<div class="carrier">
												        		<div class="flight-logo">
																	<img src="{{$flight->imageUrl}}" atl="{{$flight->imageName}}">
																</div>
												        		<span>{{$flight->imageName.' - '.$flight->flightNumber}}</span>
												        	</div>
														</div>
														@if(($i+1) < count($oSegment)) 
															@php $stoptime = 
																(new DateTime($oSegment[$i + 1]->departureDate. ' ' .$oSegment[$i + 1]->departureTime))
																->diff(new DateTime($oSegment[$i]->arrivalDate . ' ' . $oSegment[$i]->arrivalTime))
																->format("%H giờ : %I phút")
															@endphp
															<div class="stop-time">Điểm dừng chờ: <strong> {{ $oSegment[$i]->destinationName }}</strong> <span> 
																		{{$stoptime}} </span></div>
														@endif
														@endforeach
													</div>

											    	<br/>
												
													@php ( $iSegment = $flights->Inbound)
													@if(count($iSegment))
													<div class="details-row">

														<h3 class="row-title"><b>Lượt về</b> {{$flights->Inbound[0]->departureDate}}</h3>
														@foreach($iSegment as $i => $flight)
														<div class="details-content">
															<div class="content-info">
																<div class="info-cell">
																	<h4>{{$flight->originName}}</h4>
				            										<h5 class="hop-location">{{$flight->originCode}}</h5>
																	<h5>{{$flight->departureTime}}</h5>
																</div>
																<div class="info-cell">
																	<span><i class="fa fa-plane" aria-hidden="true" style="transform: rotate(45deg); margin-left: 10px"></i></span>
																	<h4>{{$flight->destinationName}}</h4>
																	<h5 class="hop-location">{{$flight->destinationCode}}</h5>
																	<h5>{{$flight->arrivalTime}}</h5>        					
																</div>
																<div class="info-cell">
																	<h5>Thời gian bay</h5>
																	<h5>{{$flight->duration_h}}  giờ :  {{$flight->duration_m}}  phút</h5>        					
																</div>
															</div>
												        	<div class="carrier">
												        		<div class="flight-logo">
																	<img src="{{$flight->imageUrl}}" atl="{{$flight->imageName}}">
																</div>
												        		<span>{{$flight->imageName.' - '.$flight->flightNumber}}</span>
												        	</div>
														</div>
														@if(($i+1) < count($iSegment)) 
															@php
															$stoptime = 
																(new DateTime($iSegment[$i + 1]->departureDate. ' ' .$iSegment[$i + 1]->departureTime))
																->diff(new DateTime($iSegment[$i]->arrivalDate . ' ' . $iSegment[$i]->arrivalTime))
																->format("%H giờ : %I phút")
															@endphp
															<div class="stop-time">Điểm dừng chờ: <strong> {{ $iSegment[$i]->destinationName }}</strong> <span> 
																		{{$stoptime}}</span></div>
														@endif
														@endforeach
													</div>
													@endif
												</div>
											</div>
											<div class="col-md-4 book-payment">
												<div class="book-info">
													<table class="table table-hover">
														<thead>
													      	<tr>
														        <th colspan="2">
																	<h3>Thông Tin Đặt Vé</h3>
																</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Họ Tên:</td>
																<td>{{$flights->Round->fullName}}</td>
															</tr>
															<tr>
																<td>Email:</td>
																<td>{{$flights->Round->email}}</td>
															</tr>
															<tr>
																<td>Số Điện Thoại:</td>
																<td>{{$flights->Round->phone}}</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="payment-info">
													<table class="table table-hover">
														<thead>
													      	<tr>
														        <th colspan="2">
																	<h3>Thông Tin Thanh Toán</h3>
																</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Họ Tên:</td>
																<td>{{$flights->Payment[0]->name}}</td>
															</tr>
															<tr>
																<td>Email:</td>
																<td>{{$flights->Payment[0]->email}}</td>
															</tr>
															<tr>
																<td>Số Tiền:</td>
																<td>{{$flights->Payment[0]->amount_total.' '.$flights->Payment[0]->amount_currency}}</td>
															</tr>
															<tr>
																<td>Ngày Thanh Toán:</td>
																<td>{{$flights->Payment[0]->payment_time}}</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
									      </div>
									   	</div>
									 </div>
					      		@endforeach
					     		</div>
					      </div>
					    </div>
			     	</div>
		        </div>
		     </div>
	   	</li>
	   	@endif
	   	@if(count($hotels) > 0)
	    <li class="timeline-inverted">
		     <div class="timeline-badge hotel"><i class="fa fa-bed" aria-hidden="true"></i></div>
		     <div class="timeline-panel">
		        <div class="timeline-heading">
		        </div>
		        <div class="timeline-body">
			        <div class="panel panel-default">
				       <a role="button" data-toggle="collapse" data-parent="#report-list" href="#collapse-hotel" aria-expanded="true" aria-controls="collapseOne">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title clearfix">
						          <div class="col-md-12">
						          		<h4>Khách sạn tại đâu đó xử lý sau</h4>
						          </div>
						      </h4>
						    </div>
				        </a>

					    <div id="collapse-hotel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					      <div class="panel-body">
					          	<div class="panel-group" id="accordion-hotel" role="tablist" aria-multiselectable="true">
					          	@foreach($hotels as $key => $hotel)
					          		@php 
					          			$hotel_details = $hotel->Hotel;
					          			$payment = $hotel->Payment;
					          		@endphp
									<div class="panel panel-default  col-md-12">
								       	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-hotel-{{$key}}" aria-expanded="true" aria-controls="collapseOne">
										    <div class="panel-heading" role="tab" id="headingOne">
										      	<div class="row">
										          	<div class="col-md-8">
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
										          		<h4>Tổng giá <span>{{number_format($hotel_details->price,0,",",".")}}<sup>đ</sup></span> <span style="color: grey; font-size: 14px;">({{$hotel_details->rooms}} x {{$hotel_details->room_type}})</span></h4>
										          </div>
											      <div class="col-md-4"><h4 style="color: grey; text-align: right;">{{$hotel_details->reviews->reviews_count}} nhận xét</h4></div>
										        </div>
										    </div>
								        </a>
									    <div id="collapse-hotel-{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
									      <div class="panel-body">
									      	<div class="row">
										      	<div class="col-md-8">
											      <div class="details" data-target='@{{data-target}}'>
												       <div class="image-gallery">
												          <ul>
												            @foreach ($hotel_details->hotel->image_url as $i => $value)
												            	@if($i == 9) @break; @endif
															    <li data-toggle="modal" data-target="#imageModal"><a href="#myGallery" data-slide-to="{{$i}}"><img class="img-responsive first}}" src="http://{{$value->url}}" alt="{{$hotel_details->hotel->name}}"></a></li>
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
												            <p style="padding-top: 10px;">Địa Chỉ: {{$hotel_details->hotel->location}}</p>
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
												 <div class="col-md-4 book-payment">
												 	<div class="book-info">
														<table class="table table-hover">
															<thead>
														      	<tr>
															        <th colspan="2">
																		<h3>Thông Tin Đặt Vé</h3>
																	</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Họ Tên:</td>
																	<td>{{$hotel_details->user->full_name}}</td>
																</tr>
																<tr>
																	<td>Email:</td>
																	<td>{{$hotel_details->user->email}}</td>
																</tr>
																<tr>
																	<td>Số Điện Thoại:</td>
																	<td>{{$hotel_details->user->phone}}</td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="payment-info">
														<table class="table table-hover">
															<thead>
														      	<tr>
															        <th colspan="2">
																		<h3>Thông Tin Thanh Toán</h3>
																	</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Họ Tên:</td>
																	<td>{{$payment[0]->name}}</td>
																</tr>
																<tr>
																	<td>Email:</td>
																	<td>{{$payment[0]->email}}</td>
																</tr>
																<tr>
																	<td>Số Tiền:</td>
																	<td>{{$payment[0]->amount_total.' '.$payment[0]->amount_currency}}</td>
																</tr>
																<tr>
																	<td>Ngày Thanh Toán:</td>
																	<td>{{$payment[0]->payment_time}}</td>
																</tr>
															</tbody>
														</table>
													</div>
												 </div>
											</div>
									      </div>
									   	</div>
									 </div>
								@endforeach
		      					</div>
		      			  </div>
		      			</div>
		      		</div>
		     	</div>
		     </div>
	    </li>
	   	@endif
	   	@if(count($cars) > 0)
	    <li class="timeline-inverted">
		     <div class="timeline-badge car"><i class="fa fa-car" aria-hidden="true"></i></div>
		     <div class="timeline-panel">
		        <div class="timeline-heading">
		        </div>
		        <div class="timeline-body">
			        <div class="panel panel-default">
				       <a role="button" data-toggle="collapse" data-parent="#report-list" href="#collapse-car" aria-expanded="true" aria-controls="collapseOne">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title clearfix">
						          <div class="col-md-12">
						          		<h4>Danh sách Xe thuê</h4>
						          </div>
						      </h4>
						    </div>
				        </a>

					    <div id="collapse-car" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					      <div class="panel-body">
					          	<div class="panel-group" id="accordion-car" role="tablist" aria-multiselectable="true">
					          	@foreach($cars as $key => $car)
					          	@php
					          		$car_details = $car->Car;
					          		$payment = $car->Payment;
					          	@endphp
									<div class="panel panel-default  col-md-12">
								       	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-car-{{$key}}" aria-expanded="true" aria-controls="collapseOne">
										    <div class="panel-heading" role="tab" id="headingOne">
										      	<div class="row">
										          	<div class="col-md-8">
										          		<h4>{{ $car_details->vehicle }}</h4>
										          	</div>
										          	<div class="col-md-4">
											    	</div>
											    </div>
											    <div class="row">
										          <div class="col-md-8">
										          		<h4>Tổng giá: <span>{{number_format($car_details->price,0,",",".")}}<sup>đ</sup></span> </h4>
										          </div>
											      <div class="col-md-4"></div>
										        </div>
										    </div>
								        </a>
									    <div id="collapse-car-{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
									      <div class="panel-body">
										      <div class="row">
										      	<div class="col-md-8">
											      	<div class="row">
											      		<div class="col-md-6">
											      			<h4><b>{{ $car_details->vehicle }}</b></h4>
											      			<img class="img-responsive car-img" src="{{  $car_details->image }}">
											      			<br/>
											      			<div class="info">
											      				<div class="col-md-6">
											      					<ul>
											      						<li>{{ $car_details->seats}} Chỗ </li>
											      						<li>{{ $car_details->doors}} Cửa </li>
											      						<li>{{ $car_details->doors}} Túi có thể đựng </li>
											      					</ul>
											      				</div>
											      				<div class="col-md-6">
											      					<ul>
											      						@if($car_details->air_conditioning)
											      							<li><i class="fa fa-check" aria-hidden="true"></i> Điều hoà</li>
											      						@else
											      							<li><i class="fa fa-times" aria-hidden="true"></i> Điều hoà </li>
											      						@endif
											      						@if($car_details->manual)
											      							<li><i class="fa fa-check" aria-hidden="true"></i> Số Tự Động</li>
											      						@else
											      							<li><i class="fa fa-times" aria-hidden="true"></i>  Số Tự Động</li>
											      						@endif
											      						@if($car_details->mandatory_chauffeur)
											      							<li><i class="fa fa-check" aria-hidden="true"></i> Tài Xế</li>
											      						@else
											      							<li><i class="fa fa-times" aria-hidden="true"></i> Tài Xế</li>
											      						@endif
											      					</ul>
											      				</div>
											      			</div>
											      		</div>
											      		<div class="col-md-6 car-details">
											      			<div class="col-md-12">
											      				<h4>Loại xe: {{ $car_details->car_class_name}}</h4>
											      				<h5>
											      					<span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
																	<span>Điểm nhận xe:</span>
																	<span>{{ $car_details->pick_up_place }}</span>
																</h5>
											      			</div>
											      			<div class="col-md-12"  style="margin-top: 10px; border-top: 1px solid lightgrey; padding-top: 15px;">
											      				<h5>Thông tin khác:</h5>
											      				<ul>
										      						@if($car_details->fuel_policy)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Nguyên liệu đầy bình</li>
										      						@else
										      							<li><i class="fa fa-times" aria-hidden="true"></i> Nguyên liệu đầy bình</li>
										      						@endif
										      						@if(!$car_details->unlimited)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Không giới hạn quãng đường</li>
										      						@else
										      							<li><i class="fa fa-times" aria-hidden="true"></i> Giới hạn quãng đường  {{$car_details->unit}}</li>
										      						@endif
										      						@if($car_details->free_breakdown_assistance)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Hỗ trợ hỏng xe</li>
										      						@else
										      							<li><i class="fa fa-times" aria-hidden="true"></i> Hỗ trợ hỏng xe</li>
										      						@endif
										      						@if($car_details->free_damage_refund_insurance)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Bảo hiểm tai nạn</li>
										      						@else
										      							<li><i class="fa fa-times" aria-hidden="true"></i> Bảo hiểm tai nạn</li>
										      						@endif
										      						@if($car_details->theft_protection_insurance)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Bảo hiểm chống trộm</li>
										      						@else
										      							<li><i class="fa fa-times" aria-hidden="true"></i> Bảo hiểm chống trộm</li>
										      						@endif
										      						@if($car_details->third_party_cover_insurance)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Bảo hiểm bên thứ ba</li>
										      						@else
										      							<li><i class="fa fa-times" aria-hidden="true"></i> Bảo hiểm bên thứ ba</li>
										      						@endif

										      					</ul>
											      			</div>
											      		</div>
											      	</div>
										      	</div>
										      	<div class="col-md-4 book-payment">
										      		<div class="book-info">
														<table class="table table-hover">
															<thead>
														      	<tr>
															        <th colspan="2">
																		<h3>Thông Tin Đặt Vé</h3>
																	</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Họ Tên:</td>
																	<td>{{$car_details->user->full_name}}</td>
																</tr>
																<tr>
																	<td>Email:</td>
																	<td>{{$car_details->user->email}}</td>
																</tr>
																<tr>
																	<td>Số Điện Thoại:</td>
																	<td>{{$car_details->user->phone}}</td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="payment-info">
														<table class="table table-hover">
															<thead>
														      	<tr>
															        <th colspan="2">
																		<h3>Thông Tin Thanh Toán</h3>
																	</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Họ Tên:</td>
																	<td>{{$payment[0]->name}}</td>
																</tr>
																<tr>
																	<td>Email:</td>
																	<td>{{$payment[0]->email}}</td>
																</tr>
																<tr>
																	<td>Số Tiền:</td>
																	<td>{{$payment[0]->amount_total.' '.$payment[0]->amount_currency}}</td>
																</tr>
																<tr>
																	<td>Ngày Thanh Toán:</td>
																	<td>{{$payment[0]->payment_time}}</td>
																</tr>
															</tbody>
														</table>
													</div>
										      	</div>
										      </div>
									      </div>
									   	</div>

					 				</div>
								@endforeach
		      					</div>
		      			  </div>
		      			</div>
		      		</div>
		     	</div>
		     </div>
	    </li>
	   	@endif
	</ul>
</div>



@endsection
@section('footer')
	@include('layouts.footer')
@endsection


@section('scripts')
  @parent
  <script type="text/javascript">
	  if($('#accordion-flight').children('.panel-default').length == 1) {
	  	$('#collapse0').collapse('show');
	  }
	  if($('#accordion-hotel').children('.panel-default').length == 1) {
	  	$('#collapse0').collapse('show');
	  }
  </script>
@endsection