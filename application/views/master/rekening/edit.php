<input type="hidden" name="kode" value="<?= $data['id_account'] ?>">
<div class="form-group">
    <label>Pilih Bank</label>
    <select class="form-control select2" name="code" data-placeholder="Pilih Bank" style="width: 100%;">
        <option value=""></option>
        <?php foreach ($bank as $b) { ?>
            <option value="<?= $b['id_bank'] ?>" <?= $b['id_bank'] == $data['bank_account'] ? 'selected' : null ?>><?= $b['nama_bank'] . ' (' . $b['code_bank'] . ')' ?></option>
        <?php } ?>
    </select>
    <div id="code"></div>
</div>
<div class="form-group">
    <label>Kantor Cabang</label>
    <input type="text" name="cabang" id="cabang" class="form-control" value="<?= $data['kcb_account'] ?>">
</div>
<div class="form-group">
    <label>No Rekening</label>
    <input type="text" name="norek" id="norek" class="form-control" value="<?= $data['norek_account'] ?>">
</div>
<div class="form-group">
    <label>Atasnama</label>
    <input type="text" name="holder" id="holder" class="form-control" value="<?= $data['pemilik_account'] ?>">
</div>
<div class="form-group">
    <label>Logo Bank</label>
    <input id="upload_image" name="gambar" type="file">
    <small>
        <p class="help-block">Kosongkan jika tidak ingin merubah gambar sebelumnya<br>Ukuran file maks: 1MB</p>
    </small>
    <div id="pesan_gambar"></div>
</div>
<div class="form-group">
    <label>Pilih Status</label>
    <select class="form-control" name="status" id="status">
        <option value="">--- Pilih ---</option>
        <option value="1" <?= $data['status_account'] == 1 ? 'selected' : null ?>>Aktif</option>
        <option value="2" <?= $data['status_account'] == 2 ? 'selected' : null ?>>Tidak Aktif</option>
    </select>
</div>
<script>
    $(document).ready(function() {
        var img_fileinput_setting = {
            showUpload: false,
            showPreview: true,
            browseLabel: 'Telusuri...',
            removeLabel: 'Hapus',
            previewSettings: {
                image: {
                    width: 'auto',
                    height: 'auto',
                    'max-width': '100%',
                    'max-height': '100%'
                },
            },
        };
        $('#upload_image').fileinput(img_fileinput_setting);
        $('.select2').select2();
    });
</script>