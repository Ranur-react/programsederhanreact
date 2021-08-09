@section(style)
<link rel="stylesheet" href="<?= assets() ?>plugins/iCheck/square/blue.css">
<link rel="stylesheet" href="<?= assets() ?>css/login.css">
@endsection
@section(content)
<div class="login-box">
    <div class="login-box-body">
        <div class="login-logo">
            <img src="<?= logoApp() ?>">
        </div>
        <p class="login-box-msg">Masuk ke akun Anda</p>
        <?= form_open('login/signin', ['id' => 'form_signin']) ?>
        <div class="form-group has-feedback">
            <input type="text" name="username" class="form-control" placeholder="Username" autofocus>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span id="username_error" class="text-red"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <span id="password_error" class="text-red"></span>
        </div>
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-xs-6">
                <div class="checkbox icheck" style="margin-top: 5px;">
                    <label>
                        <input type="checkbox" name="remember"> Ingatkan saya
                    </label>
                </div>
            </div>
            <div class="col-xs-6">
                <span class="pull-right help-block"><a href="#" class="text-muted">Lupa Password?</a></span>
            </div>
        </div>
        <button type="submit" id="btn_signin" class="login btn btn-primary btn-block" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading...">Masuk</button>
        <a href="<?= site_url('registrasi') ?>" class="btn btn-default btn-block">Registrasi</a>
        <?= form_close() ?>
    </div>
</div>
@endsection
@section(script)
<script src="<?= assets() ?>plugins/iCheck/icheck.min.js"></script>
<script src="<?= assets() ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= assets_js() ?>common.js"></script>
<script src="<?= assets_js() ?>auth/login.js"></script>
@endsection