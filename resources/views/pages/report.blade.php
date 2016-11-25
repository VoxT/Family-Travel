@extends('layouts.master')
@section('title', 'Trang Đặt Chỗ')

@section('content')

@php
	$flight_round = json_decode(json_encode($data['flights']));
	$hotels = json_decode(json_encode($data['hotels']));
@endphp
<div class="container" style="padding-top: 62px;">

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
									<div class="panel panel-default">
								       	<a role="button" data-toggle="collapse" data-parent="#accordion-flight" href="#collapse{{$key}}" aria-expanded="true" aria-controls="collapseOne">
										    <div class="panel-heading" role="tab" id="headingOne">
										      <h4 class="panel-title clearfix">
										          <div class="col-md-12">
										          		<h4>{{$flights->Outbound[0]->originName}} - {{$flights->Outbound[count($flights->Outbound) - 1]->destinationName}}</h4>
										          </div>
										          <div class="col-md-12">
										          		<h4>Tổng giá <span>{{number_format($flights->Round->price,0,",",".")}}<sup>đ</sup></span></h4>
										          </div>
										      </h4>
										    </div>
								        </a>

									    <div id="collapse{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
									      <div class="panel-body">
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
					          	@foreach($hotels as $key => $hotel_details)
									<div class="panel panel-default  col-md-12">
								       	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
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
									    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
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