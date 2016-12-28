<!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Đăng Kí</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-8 col-md-offset-2">
                    <p>Đăng Kí để đặt vé máy bay, thuê xe, đặt phòng khách sạn.</p>
                    <p>Đã có tài khoản? <a href="#" id="login">Đăng nhập</a></p>
                </div>
                <div class="clearfix"></div>
                    <form class="form-horizontal" id="formRegister" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="full_name" class="col-md-4 control-label">Họ Tên</label>

                            <div class="col-md-6">
                                <input id="full_name" type="text" class="form-control" name="full_name" value="" required autofocus>
                                <small class="help-block"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="" required>
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
                            <label for="password-confirm" class="col-md-4 control-label">Nhập lại Mật Khẩu</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                <small class="help-block"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Đăng Kí
                                </button>
                            </div>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>