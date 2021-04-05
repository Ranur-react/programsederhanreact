<input type="hidden" name="barang" value="<?= $data['barang'] ?>">
<div class="form-group">
    <label class="required">Barang</label>
    <input type="text" class="form-control" value="<?= $data['nama_barang'] ?>" readonly>
</div>
<div class="form-group">
    <label class="required">Pilih Satuan</label>
    <select class="form-control select2 satuan" name="satuan" style="width: 100%;" data-placeholder="Pilh Satuan">
        <option></option>
        <?php foreach ($satuan as $s) { ?>
            <option value="<?= $s['id_satuan'] ?>" <?= $s['id_satuan'] == $data['satuan'] ? 'selected' : null ?>><?= $s['nama_satuan'] ?></option>
        <?php } ?>
    </select>
    <div id="satuan"></div>
</div>
<div class="form-group">
    <label class="required">Harga</label>
    <input type="text" name="harga" id="harga" class="form-control" placeholder="Harga" value="<?= rupiah($data['harga']) ?>">
</div>
<div class="form-group">
    <label class="required">Jumlah</label>
    <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah" value="<?= ($data['jumlah']) ?>">
</div>
<script>
    $(function() {
        $('.select2').select2();

        $('#harga').keyup(function(e) {
            var nilai = formatRupiah($(this).val(), '');
            $(this).val(nilai);
        });
        $('#qty').keyup(function(e) {
            var nilai = formatRupiah($(this).val(), '');
            $(this).val(nilai);
        });
    });
</script>