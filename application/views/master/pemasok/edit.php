<input type="hidden" name="kode" value="<?= $data['id_supplier'] ?>">
<div class="form-group">
	<label>Jenis Pemasok</label>
	<select name="jenis" id="jenis" class="form-control">
		<option value="">--Pilih--</option>
		<option value="0" <?= $data['jenis_supplier'] == 0 ? 'selected' : '' ?>>Perorangan</option>
		<option value="1" <?= $data['jenis_supplier'] == 1 ? 'selected' : '' ?>>Perusahaan</option>
	</select>
</div>
<div class="form-group">
	<label>Pemasok</label>
	<input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama_supplier'] ?>">
</div>
<div class="form-group">
	<label>Alamat</label>
	<input type="text" name="alamat" id="alamat" class="form-control" value="<?= $data['alamat_supplier'] ?>">
</div>
<div class="form-group">
	<label>Telepon</label>
	<input type="text" name="telp" id="telp" class="form-control" value="<?= $data['telp_supplier'] ?>">
</div>