@extends('layouts.master')

@section('content')
<div class="container" style="margin-top: 45px">
	<div class="header">
		<h2 id="top">Thông tin cá nhân</h2>
	</div>
	<div>
	<h3 class="profile">
		<div class="row">
			<div class="col-md-11">
				<h3><span class="glyphicon glyphicon-user" ></span> Thông tin cơ bản </h3>
			</div>
			<div class = "col-md-1">
				<a href ="#" onclick="change_name()" >Thay đổi</a>
			</div>
		</div>
	</div>
	<hr>
	<div class = "row">
		<div class = "col-md-3">
			<p class="size">Họ và tên :</p> 
		</div>
		<div class = "col-md-9">
			<form class="form-group">
				 <input type="text" name="name" class="form-control" value="{{$data->full_name}}" disabled> 
			</form>
		</div>
	</div>
	<hr>
	<div class = "row">
		<div class = "col-md-3">
			<p class="size" >Mật khẩu : </p> 
		</div>
		<div class = "col-md-9">
			 <p class="size"> *********</p>
		</div>
	</div>
	<hr>
	<div class = "row">
		<div class = "col-md-3">
			<p class="size">Giới tính :</p> 
		</div>
		<div class = "col-md-9">
			 <form class="form-group">
				 <input type="text" name="gender" class="form-control" value="{{$data->gender}}" disabled> 
			</form>
		</div>
	</div>
	<hr>

	<div class = "row">
		<div class = "col-md-3">
			<p class="size">Ngày sinh :</p> 
		</div>
		<div class = "col-md-9">
			 <form class="form-group">
				 <input type="text" name="birthday" class="form-control" value="{{$data->birthday}}" disabled> 
			</form>
		</div>
	</div>
	<hr>
	
	<div class = "row">
		<div class = "col-md-3">
			<p class="size">Điện thoại : </p> 
		</div>
		<div class = "col-md-9">
			 <form class="form-group">
				 <input type="text" name="phone" class="form-control" value="{{$data->phone}}" disabled> 
			</form>
		</div>
	</div>
	<hr>
	<div class="contact">
		<h3><span class="glyphicon glyphicon-phone-alt" ></span> Thông tin liên hệ</h3>
	</div>
	<hr>
	<div class = "row">
		<div class = "col-md-3">
			<p class="size">Địa chỉ :</p> 
		</div>
		<div class = "col-md-8">
			 <form class="form-group">
				 <input type="text" name="address" class="form-control" value="{{$data->address}}" disabled> 
			</form>
		</div>
	</div>
	<hr>
	<div class = "row">
		<div class = "col-md-3">
			<p class="size">Email : </p> 
		</div>
		<div class = "col-md-8">
			 <form class="form-group">
				 <input type="text" name="email" class="form-control" value="{{$data->email}}" disabled> 
			</form>
		</div>
	</div>
	<hr>
</div> 
@endsection

@section('footer')
@include('layouts.footer')
@endsection
@section('scripts')
	<script>
	function change_name(){
		$("input").prop('disabled', false);

	}
	</script>
@endsection