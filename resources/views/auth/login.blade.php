<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Đăng Nhập</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-8 col-md-offset-2">
                        <p>Đăng nhập để đặt vé máy bay, thuê xe, đặt phòng khách sạn.</p>
                        <p>Chưa có tài khoản? <a href="#" id="register">Đăng kí</a></p>
                </div>
                <div class="clearfix"></div>
                <div id="message"></div>
                <form class="form-horizontal" id="formLogin" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label">E-Mail</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                            <small class="help-block"></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Mật Khẩu</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>
                            <small class="help-block"></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" checked> Nhớ đăng nhập
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Đăng nhập
                            </button>

                            <!-- <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                Quên mật khẩu?
                            </a> -->
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>