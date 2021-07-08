<div class="form-group">
    <label>Nama Lengkap</label>
    <input type="text" name="nama" id="nama" class="form-control">
</div>
<div class="form-group">
    <label>Username</label>
    <input type="text" name="username" id="username" class="form-control">
</div>
<div class="form-group">
    <label>Password</label>
    <input type="password" name="password" id="password" class="form-control">
</div>
<div class="form-group">
    <label>Hak Akses</label>
    <select name="role" id="role" class="form-control" onchange="get_gudang()">
        <option value="">Pilih</option>
        <?php foreach ($role as $r) { ?>
            <option value="<?= $r['id_role'] ?>"><?= $r['nama_role'] ?></option>
        <?php } ?>
    </select>
</div>
<div id="get_gudang"></div>