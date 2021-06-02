<input type="hidden" name="kode" value="<?= $data['id_role'] ?>">
<div class="form-group">
    <label>Hak Akses</label>
    <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama_role'] ?>">
</div>
<div class="form-group">
    <label>Jenis Hak Akses</label>
    <select class="form-control" name="jenis" id="jenis">
        <option value="">--- Pilih ---</option>
        <option value="1" <?= $data['jenis_role'] == '1' ? 'selected' : null ?>>Back Office</option>
        <option value="2" <?= $data['jenis_role'] == '2' ? 'selected' : null ?>>Gudang</option>
    </select>
</div>