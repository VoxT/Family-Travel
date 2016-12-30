@extends('layouts.master')
@section('title', 'Tổng hợp chuyến đi')

@section('content')

@if(isset($error))
<div class="container" id="report" style="padding-top: 162px; min-height: 500px; text-align: center;">
	<div class="alert alert-danger">
		 {{$error}}
	</div>
</div>

@else

@php
	$flight_round = json_decode(json_encode($data['flights']));
	$hotels = json_decode(json_encode($data['hotels']));
	$cars = json_decode(json_encode($data['cars']));
	$places = json_decode(json_encode($data['places']));
	$count_unpayment = 0;
	$total_money = 0;
@endphp
<div class="container" id="report" style="padding-top: 62px;">

	<div class="page-header">
		<div class="col-xs-9"  id="summary">
        	<h1 id="timeline">Tổng Hợp Chuyến Đi</h1>
        	<h3>{{$currentTour->origin_place.' - '.$currentTour->destination_place}} <span id="total_money"></span></h3>
        	<p>{{ 'Đi: '.$currentTour->outbound_date.' | Về: '.$currentTour->inbound_date}}</p>
        	<p>{{ $currentTour->adults.' Người lớn | '.$currentTour->children.' Trẻ em'}}</p>
       	</div>
		<div class="col-xs-3">
        @if(count($tours) > 1)
		 <div class="dropdown">
		    <button class="btn btn-default dropdown-toggle" type="button" id="tour-menu" data-toggle="dropdown">Xem Báo Cáo Chuyến Đi Khác 
		    <span class="caret"></span></button>
		    <ul class="dropdown-menu tour-menu" role="menu" aria-labelledby="tour-menu">
		    @foreach($tours as $tour)
		      <li role="presentation">
		      	<a role="menuitem" tabindex="-1" href="{{url('report/'.$tour->id)}}">
			      <div class="content-left">{{$tour->origin_place}}
			      	<p>{{$tour->outbound_date}}</p>
			      </div>
			      <div class="go"><i class="fa fa-angle-double-right" aria-hidden="true"></i></div>
			      <div class="content-right">{{$tour->destination_place}}
			      	<p>{{$tour->inbound_date}}</p>
			      </div>
		      	</a>
		      </li>
		    @endforeach
		    </ul>
		  </div>
		@endif
		<div id="payment-all"></div>
		</div>
    </div>
	<ul class="timeline col-xs-12">
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
						          <div class="col-xs-12">
						          		<h4>{{$flight_round[0]->Outbound[0]->originName}} - {{$flight_round[0]->Outbound[count($flight_round[0]->Outbound) - 1]->destinationName}}</h4>
						          </div>
						      </h4>
						    </div>
				        </a>

					    <div id="collapse-flight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					      <div class="panel-body">
					          	<div class="panel-group" id="accordion-flight" role="tablist" aria-multiselectable="true">
								@foreach($flight_round as $key => $flights)
									@php( $total_money += $flights->Round->price)
									<div class="print-flight">
									<div class="panel panel-default col-xs-12">
								       	<a role="button" data-toggle="collapse" data-parent="#accordion-flight" href="#collapse-flight-{{$key}}" aria-expanded="true" aria-controls="collapseOne">
										    <div class="panel-heading" role="tab" id="headingOne">
										      	<div class="row">
										          <div class="col-xs-12">
										          		<h4>{{$flights->Outbound[0]->originName}} - {{$flights->Outbound[count($flights->Outbound) - 1]->destinationName}}</h4>
										          </div>
										          <div class="col-xs-12">
										          		<h4>Tổng giá <span>{{number_format($flights->Round->price,0,",",".")}}<sup>đ</sup></span></h4>
										          </div>
										         </div>
										    </div>
								        </a>

									    <div id="collapse-flight-{{$key}}" class="panel-collapse collapse @if($key ==0) in @endif" role="tabpanel" aria-labelledby="headingOne">
									      <div class="panel-body">
									      	<div class="col-xs-8">
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
											<div class="col-xs-4 book-payment">
												<div class="book-info">
													<table class="table table-hover">
														<thead>
													      	<tr>
														        <th colspan="2" style="text-align: center;">
																	<h3>Thông Tin Đặt Vé</h3>
																</th>
															</tr>
														</thead>
														<tbody>
														@foreach($flights->Round->book_info as $key => $value)
															 <tr>
															    <th colspan="2" style="text-align: center;">Hành Khách {{$key +1}}</th>
															  </tr>
															<tr>
																<td>Họ Tên:</td>
																<td>{{$value->full_name}}</td>
															</tr>
															<tr>
																<td>Ngày Sinh:</td>
																<td>{{$value->birthday}}</td>
															</tr>
															<tr>
																<td>Giới Tính:</td>
																<td>{{$value->gender}}</td>
															</tr>
														@endforeach

															 <tr>
															    <th colspan="2" style="text-align: center;">Thông Tin Liên Hệ</th>
															  </tr>
															<tr>
																<td>Email:</td>
																<td>{{$flights->Round->email}}</td>
															</tr>
															<tr>
																<td>Số Điện Thoại:</td>
																<td>{{$flights->Round->phone}}</td>
															</tr>
															@if($flights->Round->address != '')
															<tr>
																<td>Địa Chỉ:</td>
																<td>{{$flights->Round->address}}</td>
															</tr>
															@endif
															<tr>
																<td>Ngày Đặt:</td>
																<td>{{ $flights->Round->created_at }}</td>
															</tr>
														</tbody>
													</table>
												</div>
												@if(count($flights->Payment) > 0)
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
												@else 
												@php($count_unpayment++)
												@endif
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
						          <div class="col-xs-12">
						          		<h4>Danh Sách Đặt Phòng Khách sạn</h4>
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
					          			$total_money += $hotel_details->price;
					          		@endphp
					          		<div class="print-hotel">
									<div class="panel panel-default  col-xs-12 hotel-panel">
								       	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-hotel-{{$key}}" aria-expanded="true" aria-controls="collapseOne">
										    <div class="panel-heading" role="tab" id="headingOne">
										      	<div class="row">
										          	<div class="col-xs-12">
										          		<h4>{{ $hotel_details->hotel->name }}</h4>
										          	</div>
										          <div class="col-xs-12">
										          		<h4>Tổng giá <span>{{number_format($hotel_details->price,0,",",".")}}<sup>đ</sup></span> <span style="color: grey; font-size: 14px;">({{$hotel_details->rooms}} x {{$hotel_details->room_type}})</span></h4>
										          </div>
										        </div>
										    </div>
								        </a>
									    <div id="collapse-hotel-{{$key}}" class="panel-collapse collapse @if($key ==0) in @endif" role="tabpanel" aria-labelledby="headingOne">
									      <div class="panel-body">
									      	<div class="row">
										      	<div class="col-xs-8">
											      <div class="details" data-target='@{{data-target}}'>
												       <div class="image-gallery">
												          <ul>
												            @foreach ($hotel_details->hotel->image_url as $i => $value)
												            	@if($i == 1) @break; @endif
															    <li data-toggle="modal" data-target="#imageModal"><a href="#myGallery" data-slide-to="{{$i}}"><img class="img-responsive first}}" src="http://{{$value->url}}" alt="{{$hotel_details->hotel->name}}"></a></li>
															@endforeach
												          <!--end of thumbnails-->
												          </ul>
												        </div>  
												      <div class="listing-details">
												          <h2 title="{{$hotel_details->hotel->name}}">{{$hotel_details->hotel->name}}</h2>
												          <div class="listing-details__details">
												          	<div class="stars">
												          	@for($i = 1; $i <= 5; $i++)
																@if($i <= $hotel_details->hotel->star_rating)
																	<span><i class="fa fa-star" aria-hidden="true"></i></span>
																@else 
																	<span><i class="fa fa-star-o" aria-hidden="true"></i></span>
																@endif
															@endfor
															</div>
															<h4>Địa chỉ: {{$hotel_details->hotel->location}}</4>
															<h4>Ngày Nhận Phòng: {{ $hotel_details->checkindate }}</h4>
															<h4>Ngày Trả Phòng: {{ $hotel_details->checkoutdate }}</h4>
															<h4>Số Người: {{ $hotel_details->guests }}</h4>
															<h4>Số Phòng: {{ $hotel_details->rooms.' ('.$hotel_details->room_type.')' }}</h4>
												          </div>
												      </div>
												   </div>
												 </div>
												 <div class="col-xs-4 book-payment">
												 	<div class="book-info">
														<table class="table table-hover">
															<thead>
														      	<tr>
															        <th colspan="2">
																		<h3>Thông Tin Đặt Phòng</h3>
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
																@if($hotel_details->user->address != '')
																<tr>
																	<td>Địa Chỉ:</td>
																	<td>{{$hotel_details->user->address}}</td>
																</tr>
																@endif
																<tr>
																	<td>Ngày Đặt:</td>
																	<td>{{ $hotel_details->created_at }}</td>
																</tr>
															</tbody>
														</table>
													</div>
													@if(count($payment) > 0)
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
													@else 
													@php($count_unpayment++)
													@endif
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
						          <div class="col-xs-12">
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
					          		$total_money += $car_details->price;
					          	@endphp
					          	<div class="print-car">
									<div class="panel panel-default  col-xs-12">
								       	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-car-{{$key}}" aria-expanded="true" aria-controls="collapseOne">
										    <div class="panel-heading" role="tab" id="headingOne">
										      	<div class="row">
										          	<div class="col-xs-8">
										          		<h4>{{ $car_details->vehicle }}</h4>
										          	</div>
										          	<div class="col-xs-4">
											    	</div>
											    </div>
											    <div class="row">
										          <div class="col-xs-8">
										          		<h4>Tổng giá: <span>{{number_format($car_details->price,0,",",".")}}<sup>đ</sup></span> </h4>
										          </div>
											      <div class="col-xs-4"></div>
										        </div>
										    </div>
								        </a>
									    <div id="collapse-car-{{$key}}" class="panel-collapse collapse @if($key ==0) in @endif" role="tabpanel" aria-labelledby="headingOne">
									      <div class="panel-body">
										      <div class="row">
										      	<div class="col-xs-8">
											      	<div class="row">
											      		<div class="col-xs-6">
											      			<h4><b>{{ $car_details->vehicle }}</b></h4>
											      			<img class="img-responsive car-img" src="{{  $car_details->image }}">
											      			<br/>
											      			<div class="info">
											      				<div class="col-xs-6">
											      					<ul>
											      						<li>{{ $car_details->seats}} Chỗ </li>
											      						<li>{{ $car_details->doors}} Cửa </li>
											      						<li>{{ $car_details->doors}} Túi có thể đựng </li>
											      					</ul>
											      				</div>
											      				<div class="col-xs-6">
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
											      		<div class="col-xs-6 car-details">
											      			<div class="col-xs-12">
											      				<h4>Loại xe: {{ $car_details->car_class_name}}</h4>
											      				<h4>
											      					<span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
																	<span>Điểm nhận trả xe: </span>
																	<span>{{ $car_details->pick_up_place }}</span>
																</h4>
																<h4>Thời gian nhận xe: {{ $car_details->pick_up_datetime }}</h4>
																<h4>Thời gian trả xe: {{ $car_details->drop_off_datetime }}</h4>
											      			</div>
											      			<div class="col-xs-12"  style="margin-top: 10px; border-top: 1px solid lightgrey; padding-top: 15px;">
											      				<h5>Thông tin khác:</h5>
											      				<ul>
										      						@if($car_details->fuel_policy)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Nguyên liệu đầy bình</li>
										      						@endif
										      						@if(!$car_details->unlimited)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Không giới hạn quãng đường</li>
										      						@else
										      							<li><i class="fa fa-times" aria-hidden="true"></i> Giới hạn quãng đường  {{$car_details->unit}}</li>
										      						@endif
										      						@if($car_details->free_breakdown_assistance)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Hỗ trợ hỏng xe</li>
										      						@endif
										      						@if($car_details->free_damage_refund_insurance)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Bảo hiểm tai nạn</li>
										      						@endif
										      						@if($car_details->theft_protection_insurance)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Bảo hiểm chống trộm</li>
										      						@endif
										      						@if($car_details->third_party_cover_insurance)
										      							<li><i class="fa fa-check" aria-hidden="true"></i> Bảo hiểm bên thứ ba</li>
										      						@endif

										      					</ul>
											      			</div>
											      		</div>
											      	</div>
										      	</div>
										      	<div class="col-xs-4 book-payment">
										      		<div class="book-info">
														<table class="table table-hover">
															<thead>
														      	<tr>
															        <th colspan="2">
																		<h3>Thông Tin Đặt Xe</h3>
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
																@if($car_details->user->address != '')
																<tr>
																	<td>Địa Chỉ:</td>
																	<td>{{$car_details->user->address}}</td>
																</tr>
																@endif
																<tr>
																	<td>Ngày Đặt:</td>
																	<td>{{ $car_details->created_at }}</td>
																</tr>
															</tbody>
														</table>
													</div>
													@if(count($payment) > 0)
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
													@else 
													@php($count_unpayment++)
													@endif
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
	   	@if(count($places) > 0)
	   	<li class="timeline-inverted">
		     <div class="timeline-badge place"><i class="fa fa-university" aria-hidden="true"></i></div>
		     <div class="timeline-panel">
		        <div class="timeline-heading">
		        </div>
		        <div class="timeline-body"  id="print_place">
			        <div class="panel panel-default">
				       <a role="button" data-toggle="collapse" data-parent="#report-list" href="#collapse-place" aria-expanded="true" aria-controls="collapseOne">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title clearfix">
						          <div class="col-xs-12">
						          		<h4>Danh sách Địa Điểm</h4>
						          </div>
						      </h4>
						    </div>
				        </a>

					    <div id="collapse-place"  class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
					      <div class="panel-body">
					      	<div class="col-xs-4">
					      		<div class="list-group">
					      		@foreach ($places as $key => $value)
								  <a href="#{{$key}}" class="list-group-item" geo-id="{{$key}}">
								    <div class="details">
									    <h4 class="list-group-item-heading">{{ $value->name }}</h4>
									    <p class="list-group-item-text">
									    	@for($i = 0; $i < 5; $i++)
									    		@if($i < $value->rates)
									    		<span style="font-size: 120%;color:#F9C81F;">&#9733;</span>
									    		@else
									    		<span style="font-size:120%;color:#E7E5E5;" >&#9734;</span>
									    		@endif
									    	@endfor
									    </p>
									    <p>{{ $value->address }}</p>
									</div>
								    <div class="images">
								    	<img src="{{ json_decode($value->images)[0] }}">
								    </div>
								  </a>
								 @endforeach
								</div>
					      	</div>
					      	<div class="col-xs-8">
					      		<div id="reportMap" style="height: 400px;"></div>
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

<div class="print-report">
	<button class="btn btn-danger" type="button" onclick="print_report()">
		<i class="fa fa-print" aria-hidden="true"></i> In Báo Cáo 
	</button>
</div>

@endif <!-- for error -->
@endsection <!-- end section content -->

@section('footer')
	@include('layouts.footer')
@endsection


@section('scripts')
  @parent

@if(!isset($error))
  	<script type="text/javascript">

		$('#total_money').text('| TỔNG GIÁ: {{number_format($total_money,0,",",".")}}');
  		function print_report() {
  			var content = '<div class="container">';
  			content += $('#summary').html();
  			
  			@if(count($flight_round) > 0)
	  			content += '<h1 style="text-align: center;">MÁY BAY</h1>';
	  			$('#accordion-flight').children('.print-flight').each(function(){
	  				content += $(this).html().replace('panel-collapse collapse', 'panel-collapse collapse in')
	  				.replace('data-toggle="collapse"', '');
	  				content += '<DIV class="clearfix" style="page-break-after:always"></DIV>';
	  			});
	  		@endif
	  		
	  		@if(count($hotels) > 0)
	  			content += '<h1 style="text-align: center;">KHÁCH SẠN</h1>';
	  			$('#accordion-hotel').children('.print-hotel').each(function(){
	  				content += $(this).html().replace('panel-collapse collapse', 'panel-collapse collapse in')
	  				.replace('data-toggle="collapse"', '');
	  			});
	  		@endif
	  		
	  		@if(count($cars) > 0)
	  			content += '<DIV class="clearfix" style="page-break-after:always"></DIV>';
	  			content += '<h1 style="text-align: center;">THUÊ XE</h1>';
	  			$('#accordion-car').children('.print-car').each(function(){
	  				content += $(this).html().replace('panel-collapse collapse', 'panel-collapse collapse in')  				.replace('data-toggle="collapse"', '');
	  			});
			@endif
			
			@if(count($places) > 0)
	  			content += '<DIV class="clearfix" style="page-break-after:always"></DIV>';
	  			content += '<h1 style="text-align: center;">ĐỊA ĐIỂM</h1>';
	  			
	  			content += $('.list-group').html().replace(/img/g, 'img style="height: 80px; width:80px; top: 0; right:0; position:absolute;"');
			@endif

  			content += '</div>';
  			createPopup(content);
  		}

  		function createPopup( data ) {
		    var mywindow = window.open( "", "new div", "height=980px,width=1000px" );
		    mywindow.document.write( "<html><head>" );
		    mywindow.document.write( $('head').html() );
		    mywindow.document.write( "</head><body>" );
		    mywindow.document.write( data );
		    mywindow.document.write( "</body></html>" );

		    setTimeout(function() {mywindow.print(); }, 300);
		   // setTimeout(function() {mywindow.close(); }, 210);

		    return true;

		}

  	</script>

	@if($count_unpayment > 0)
	<script type="text/javascript">
	var btn = '' + '<a id="payment-all-button" class="btn btn-default" type="button" href="'+ '{{url("payment_all/".$currentTour->id)}}' + '"> <p>THANH TOÁN NGAY<p><p>('+ {{$count_unpayment}} +' khoản chưa thanh toán) </p> </a>';
	$('#payment-all').html(btn);
	</script>
	@endif
	 
	@if(count($places) > 0)
	  <script type="text/javascript">
	  	var place_list = [];
	  	@foreach ($places as $key => $value)
	  		@php( $location = json_decode($value->location) )
	  		place_list.push({lat: {{ $location->lat }}, lng: {{ $location->lng }}, type: '{{ $value->place_type }}' });
	  	@endforeach
	  </script>
	  <script src="{{ elixir('js/report.js') }}"></script>
	  	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvf3SMKYOCFlAtjUTKotmrF6EFrEk2a40&callback=reportMap&language=vi&region=VN&libraries=places">
		</script>
	@endif
@endif
@endsection
