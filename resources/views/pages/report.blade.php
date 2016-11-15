@extends('layouts.master')
@section('title', 'Trang Đặt Chỗ')

@section('content')

@php
	$flight_round = json_decode(json_encode($data['flights']));
@endphp
<div class="container" style="padding-top: 62px;">

	<div class="page-header">
        <h1 id="timeline">Tổng Hợp Chuyến Đi</h1>
    </div>
	<ul class="timeline col-md-12">
	    <li class="timeline-inverted">
		     <div class="timeline-badge flight"><i class="fa fa-plane" aria-hidden="true"></i></div>
		     <div class="timeline-panel">
		        <div class="timeline-heading"></div>

		        <div class="timeline-body">
		          	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					@foreach($flight_round as $key => $flights)
						<div class="panel panel-default">
					       	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}" aria-expanded="true" aria-controls="collapseOne">
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
							    	<br/>
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
	   	</li>
	</ul>
</div>



@endsection
@section('footer')
	@include('layouts.footer')
@endsection


@section('scripts')
  @parent

@endsection