@extends('admin.master')

@section('sidebar')
    @include('admin.sidebar')
@endsection
@section('content')
<div class="right_col" role="main" style="min-height: 800px;">
	<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Default Example <small>Users</small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <h2> Danh sách chuyến bay </h2>
            <table class="table table-striped table-bordered datatable">
              <thead>
                <tr>
                  <th>Tên người dùng</th>
                  <th>Địa điểm đi</th>
                  <th>Địa điểm đến</th>
                  <th>Ngày đi</th>
                  <th>Ngày đến</th>
                  <th>Số người</th>
                  <th>Thanh toán</th>
                  <th>Tổng tiền</th>
                  <th>Ngày đặt</th>
                </tr>
              </thead>

             
              <tbody>
               @foreach ($data as $value)
                <tr>
                  <td><a href="users/{{$value['user_id']}}" style="color: blue">{{$value['user_name']}}</a></td>
                  <td>{{$value['origin_place']}}</td>
                  <td>{{$value['destination_place']}}</td>
                  <td>{{$value['departure_datetime']}}</td>
                  <td>{{$value['arrival_datetime']}}</td>
                  <td>{{$value['number_of_seat']}}</td>
                  @if ($value['payment_id'] == null)
                    <td>Chưa thanh toán</td>
                  @else 
                    <td><a href="payments/{{$value['payment_id']}}" style="color: blue">Đã thanh toán</a></td>
                  @endif
                  <td>{{$value['price']}}</td>
                  <td>{{$value['created_at']}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>

	</div>
</div>
@endsection