<div class="login-box">
    <div class="login-box-body">
        <div class="login-logo">
            <img src="<?= logoApp() ?>">
        </div>
        <p class="login-box-msg">Registrasi Akun Baru</p>
        <div id="message"></div>
        <?= form_open('registrasi/signup', ['id' => 'form_signup']) ?>
        <div class="form-group has-feedback">
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap" autofocus>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="username" id="username" class="form-control" placeholder="Username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <select name="jenis" id="jenis" class="form-control" onchange="get_level();get_gudang()">
                <option value="">--- Jenis Pengguna ---</option>
                <option value="1">Back Office</option>
                <option value="2">Gudang</option>
            </select>
        </div>
        <div class="form-group has-feedback">
            <select name="level" id="level" class="form-control">
                <option value="">--- Pilih Level ---</option>
            </select>
        </div>
        <div id="get_gudang"></div>
        <button type="submit" id="btn_signup" class="signup btn btn-primary btn-block" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading...">Registrasi</button>
        <a href="<?= site_url() ?>" class="btn btn-default btn-block">Login</a>
        <?= form_close() ?>
    </div>
</div>