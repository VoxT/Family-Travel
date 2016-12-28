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
            <h2> Danh sách địa điểm </h2>
            <table class="table table-striped table-bordered datatable">
              <thead>
                <tr>
                  <th>Tên người dùng</th>
                  <th>Tên địa điểm</th>
                  <th>Vị trí</th>
                  <th>Loại địa điểm</th>
                  <th>Ngày tạo</th>
                </tr>
              </thead>

             
              <tbody>
               @foreach ($data as $value)
                <tr>
                  <td><a href="users/{{$value['user_id']}}" style="color: blue">{{$value['user_name']}}</a></td>
                  <td>{{$value['place']->name}}</td>
                  <td>{{$value['place']->address}}</td>
                  <td>{{$value['place']->place_type}}</td>
                  <td>{{$value['place']->created_at}}</td>
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