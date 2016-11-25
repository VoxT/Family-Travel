@extends('layouts.master')
@section('title', 'Trang Đặt Chỗ')

@section('content')
@php
	$car_details =  json_decode($carDetails);
@endphp
<div class="container" style="padding-top: 62px;">

	<div class="page-header">
        <h1 id="timeline">Thuê Xe</h1>
    </div>
	<ul class="timeline col-md-10 col-md-offset-1">
	    <li class="timeline-inverted">
		     <div class="timeline-badge car"><i class="fa fa-car" aria-hidden="true"></i></div>
		     <div class="timeline-panel">
		        <div class="timeline-heading">
		        </div>
		        <div class="timeline-body" id="car-booking">
		          	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default  col-md-7">
					       	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
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
							          		<h4>Tổng giá: <span>{{number_format($car_details->price_all_days,0,",",".")}}<sup>đ</sup></span> </h4>
							          </div>
								      <div class="col-md-4"></div>
							        </div>
							    </div>
					        </a>
						    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						      <div class="panel-body">
						      	<div class="row">
						      		<div class="col-md-6">
						      			<h4><b>{{ $car_details->vehicle }}</b></h4>
						      			<img class="img-responsive car-img" src="{{  $car_details->image_url }}">
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
						      				<h5>Loại xe: {{ $car_details->car_class_name}}</h5>
						      				<h5>
						      					<span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
												<span>Điểm nhận xe:</span>
												<span>{{ $car_details->pick_up_address }}</span>
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
						   	</div>

						 </div>

					<form action="postCar" method="post" id="postCar" enctype='application/json'>
							 {{ csrf_field() }}
						<input type="hidden" name="cardetails" value="">
  						<input type="hidden" name="tourId" value="{{$tourId}}">
						
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
		                            <button type="button" class="btn btn-primary col-md-12" id="book">
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


@section('scripts')
  @parent

<script type="text/javascript">
	var json = @php echo $carDetails; @endphp;
	var carJson = JSON.stringify(json);
	$(document).on('click', '#book', function() {
		$('input[name="cardetails"').val(carJson);
		$('#postCar').submit();
	});
</script>

@endsection