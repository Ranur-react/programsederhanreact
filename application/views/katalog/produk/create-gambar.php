<input type="hidden" name="kode" value="<?= $data['kode'] ?>">
<input type="hidden" name="action" value="<?= $data['action'] ?>">
<div class="form-group">
    <label>Satuan</label>
    <select class="form-control select2" name="satuan" data-placeholder="Pilih Satuan" style="width: 100%;">
        <option value=""></option>
        <?php foreach ($satuan as $s) { ?>
            <option value="<?= $s['id_satuan'] ?>"><?= $s['nama_satuan'] ?></option>
        <?php } ?>
    </select>
    <div id="satuan"></div>
</div>
<div class="form-group">
    <label>Icon Kategori</label>
    <input id="upload_image" name="gambar" type="file">
    <small>
        <p class="help-block">Ukuran file maks: 1MB</p>
    </small>
    <div id="pesan_gambar"></div>
</div>
<script>
    $(document).ready(function() {
        var img_fileinput_setting = {
            showUpload: false,
            showPreview: false,
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
        $(".select2").select2();
    });
</script>