<input type="hidden" name="kode" value="<?= $data->id_konversi ?>">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Dari</label>
            <select name="terbesar" id="terbesar" class="form-control">
                <option value="">-- Pilih --</option>
                <?php foreach ($satuan as $s) { ?>
                    <option value="<?= $s['id_satuan'] ?>" <?= $s['id_satuan'] == $data->idsatuan_terbesar ? 'selected' : '' ?>><?= $s['nama_satuan'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Ke</label>
            <select name="terkecil" id="terkecil" class="form-control">
                <option value="">-- Pilih --</option>
                <?php foreach ($satuan as $s) { ?>
                    <option value="<?= $s['id_satuan'] ?>" <?= $s['id_satuan'] == $data->idsatuan_terkecil ? 'selected' : '' ?>><?= $s['nama_satuan'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <label>Nilai Konversi</label>
    <input type="text" name="nilai" id="nilai" autocomplete="off" class="form-control" value="<?= rupiah($data->nilai_konversi) ?>">
</div>
<script>
    $(function() {
        $('#nilai').keyup(function(e) {
            var nilai = formatted($(this).val(), '');
            $(this).val(nilai);
        });
    });
</script>