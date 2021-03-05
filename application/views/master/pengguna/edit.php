<input type="hidden" name="kode" value="<?= $data['id_user'] ?>">
<div class="form-group">
    <label>Nama Lengkap</label>
    <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama_user'] ?>">
</div>
<div class="form-group">
    <label>Username</label>
    <input type="text" name="username" id="username" class="form-control" value="<?= $data['username'] ?>">
</div>
<div class="form-group">
    <label>Password</label>
    <input type="password" name="password" id="password" class="form-control">
    <span class="help-block"><i>Kosongkan jika tidak rubah password</i></span>
</div>
<div class="form-group">
    <label>Status</label>
    <select name="status" id="status" class="form-control">
        <option value="">-- Pilih --</option>
        <option value="1" <?= $data['status_user'] == 1 ? 'selected' : null ?>>Aktif</option>
        <option value="0" <?= $data['status_user'] == 0 ? 'selected' : null ?>>Tidak Aktif</option>
    </select>
</div>