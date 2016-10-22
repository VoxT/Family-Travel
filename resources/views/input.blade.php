<!DOCTYPE html>
<html>
<head>
	<title>test</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="{{ elixir('css/app.css') }}">
	<script type="text/javascript"  src="{{ elixir('js/autocomplete.js') }}"></script> 
</head>
<body>
	<div style="margin-left: 200px;margin-right: 200px;margin-top: 100px  ">
	<form class="form-horizontal" method="post" action="/input/view">
		<div class="form-group">
			<div class="col-sm-6">
				<label>Từ</label>
				<input class="form-control" type="text" name="originplace" id ="originplace">				
			</div>	
			<div class="col-sm-6">
				<label>Đến</label>					
				<input class="form-control" type="text" name="destinationplace" id ="destinationplace">
			</div>	
		</div>
		<div class="form-group">
			<div class="col-sm-3">
				<label>Khởi hành</label>
				<input class="form-control" type="text" name="outbounddate" id ="outbounddate">
			</div>	
			<div class="col-sm-3 ">
				<label>Về</label>
				<input class="form-control" type="text" name="inbounddate" id ="inbounddate">
			</div>
			<div class="col-sm-6">
				<label>Người lớn</label>					
				<input class="form-control" type="number" name="adults" id ="adults">
			</div>
		</div>
		<div class="form-group" style="margin: auto; ">
			<button type="submit" class="btn btn-primary" id = "click"> Tìm chuyến bay</button>
			
		</div>
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	</form>
	</div>
	
</body>
</html>