<div class="form-group">
    <label>Pilih Bank</label>
    <select class="form-control select2" name="code" data-placeholder="Pilih Bank" style="width: 100%;">
        <option value=""></option>
        <?php foreach ($bank as $b) { ?>
            <option value="<?= $b['id_bank'] ?>"><?= $b['nama_bank'] . ' (' . $b['code_bank'] . ')' ?></option>
        <?php } ?>
    </select>
    <div id="code"></div>
</div>
<div class="form-group">
    <label>Kantor Cabang</label>
    <input type="text" name="cabang" id="cabang" class="form-control">
</div>
<div class="form-group">
    <label>No Rekening</label>
    <input type="text" name="norek" id="norek" class="form-control">
</div>
<div class="form-group">
    <label>Atasnama</label>
    <input type="text" name="holder" id="holder" class="form-control">
</div>
<div class="form-group">
    <label>Logo Bank</label>
    <input id="upload_image" name="gambar" type="file">
    <small>
        <p class="help-block">Kosongkan jika tidak ada file<br>Ukuran file maks: 1MB</p>
    </small>
    <div id="pesan_gambar"></div>
</div>
<div class="form-group">
    <label>Pilih Status</label>
    <select class="form-control" name="status" id="status">
        <option value="">--- Pilih ---</option>
        <option value="1">Aktif</option>
        <option value="2">Tidak Aktif</option>
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