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
                  <th>Địa điểm đi</th>
                  <th>Địa điểm đến</th>
                  <th>Ngày đi</th>
                  <th>Ngày đến</th>
                  <th>Số người</th>
                  <th>Thanh toán</th>
                  <th>Tổng tiền</th>
                </tr>
              </thead>

             
              <tbody>
               @foreach ($flights as $value)
                <tr>
                  <td>{{$value['origin_place']}}</td>
                  <td>{{$value['destination_place']}}</td>
                  <td>{{$value['departure_datetime']}}</td>
                  <td>{{$value['arrival_datetime']}}</td>
                  <td>{{$value['number_of_seat']}}</td>
                  @if ($value['payment_id'] == 'null')
                    <td>Chưa thanh toán</td>
                  @else 
                    <td><a>Đã thanh toán</a></td>
                  @endif
                  <td>{{$value['price']}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="x_content">
            <h2> Danh sách khách sạn </h2>
            <table class="table table-striped table-bordered datatable">
              <thead>
                <tr>
                  <th>Tên khách sạn</th>
                  <th>Ngày nhận phòng</th>
                  <th>Ngày trả phòng</th>
                  <th>Số người</th>
                  <th>Số phòng</th>
                  <th>Thanh toán</th>
                  <th>Tổng tiền</th>
                </tr>
              </thead>

             
              <tbody>
               @foreach ($hotels as $value)
                <tr>
                  <td>{{$value->name}}</td>
                  <td>{{$value->check_in_date}}</td>
                  <td>{{$value->check_out_date}}</td>
                  <td>{{$value->guests}}</td>
                  <td>{{$value->rooms}}</td>
                  @if ($value->payment_id == 'null')
                    <td>Chưa thanh toán</td>
                  @else 
                    <td><a>Đã thanh toán</a></td>
                  @endif
                  <td>{{$value->price}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="x_content">
            <h2> Danh sách thuê xe </h2>
            <table class="table table-striped table-bordered datatable">
              <thead>
                <tr>
                  <th>Tên xe</th>
                  <th>Địa điểm nhận xe</th>
                  <th>Địa điểm trả xe</th>
                  <th>Ngày nhận xe</th>
                  <th>Ngày trả xe</th>
                  <th>Thanh toán</th>
                  <th>Tổng tiền</th>
                </tr>
              </thead>

             
              <tbody>
               @foreach ($cars as $value)
                <tr>
                  <td>{{$value->vehicle}}</td>
                  <td>{{$value->pick_up_place}}</td>
                  <td>{{$value->drop_off_place}}</td>
                  <td>{{$value->pick_up_datetime}}</td>
                  <td>{{$value->drop_off_datetime}}</td>
                  @if ($value->payment_id == 'null')
                    <td>Chưa thanh toán</td>
                  @else 
                    <td><a>Đã thanh toán</a></td>
                  @endif
                  <td>{{$value->price}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="x_content">
            <h2> Danh sách địa điểm </h2>
            <table class="table table-striped table-bordered datatable">
              <thead>
                <tr>
                  <th>Tên địa điểm</th>
                  <th>Vị trí</th>
                  <th>Loại địa điểm</th>
                </tr>
              </thead>

             
              <tbody>
               @foreach ($places as $value)
                <tr>
                  <td>{{$value->name}}</td>
                  <td>{{$value->address}}</td>
                  <td>{{$value->place_type}}</td>
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