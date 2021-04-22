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
        <?= form_close() ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
        $('#form_signin').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#btn_signin').button('loading');
                },
                success: function(data) {
                    if (data.status == "0101") {
                        if (data.username_error != '') {
                            $('#username_error').html(data.username_error);
                        } else {
                            $('#username_error').html('');
                        }
                        if (data.password_error != '') {
                            $('#password_error').html(data.password_error);
                        } else {
                            $('#password_error').html('');
                        }
                    } else {
                        window.location.href = "<?= site_url('welcome') ?>";
                    }
                    $('.btn_signin').button('reset');
                },
                complete: function() {
                    $('#btn_signin').button('reset');
                }
            })
        });
    });
</script>