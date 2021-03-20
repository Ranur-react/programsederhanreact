<input type="hidden" name="kode" value="<?= $data['id_kategori'] ?>">
<div class="form-group">
    <label>Nama Kategori</label>
    <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama_kategori'] ?>">
</div>
<div class="form-group">
    <label>Slug Kategori</label>
    <input type="text" name="slug" id="slug" class="form-control" value="<?= $data['slug_kategori'] ?>">
</div>
<div class="form-group">
    <label>Icon Kategori</label>
    <input id="upload_image" name="gambar" type="file">
    <small>
        <p class="help-block">Kosongkan jika tidak ingin merubah gambar sebelumnya<br>Ukuran file maks: 1MB</p>
    </small>
    <div id="pesan_gambar"></div>
</div>
<div class="form-group">
    <label>Sub Kategori</label>
    <select class="form-control select2" name="parent" data-placeholder="Pilih Kategori" style="width: 100%;">
        <option value=""></option>
        <option value="0" <?= $data['parent_kategori'] == '0' ? 'selected' : null ?>>None</option>
        <?php foreach ($parent as $p) { ?>
            <option value="<?= $p['id'] ?>" <?= $p['id'] == $data['parent_kategori'] ? 'selected' : null ?>><?= $p['nama'] ?></option>
        <?php } ?>
    </select>
    <div id="parent"></div>
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
    });
</script>