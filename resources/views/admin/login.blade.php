@extends('admin.master')

@section('sidebar')
@endsection
@section('content')
    <div>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="postlogin" method="post">
            {{ csrf_field() }}
              <h1>Login Form</h1>
              @if(isset($error))
              <div class="alert alert-danger">
              	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  {{$error}}
				</div>
				@endif
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" name="email">
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" name="password">
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Log in</button>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>
              <br>
              <div class="clearfix"></div>
                  <h1><i class="fa fa-paw"></i> FamilyTravel</h1>
                  <p>©2016 Luận văn tốt nghiệp đại học</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
@endsection