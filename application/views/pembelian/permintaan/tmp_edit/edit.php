<input type="hidden" name="kode" value="<?= $data['id_detail'] ?>">
<div class="panel panel-default">
    <div class="panel-body panel-body-custom">
        <div class="row">
            <div class="col-lg-12 col-xs-12 ">
                <div class="row">
                    <div class="col-md-12"><b>Produk</b> <span style="margin: 0 10px 0 10px;">:</span><?= $data['nama_barang'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="required">Pilih Satuan</label>
    <select class="form-control select2 satuan" name="satuan" style="width: 100%;" data-placeholder="Pilh Satuan">
        <option></option>
        <?php foreach ($satuan as $s) { ?>
            <option value="<?= $s['id_brg_satuan'] ?>" <?= $s['id_brg_satuan'] == $data['barang_detail'] ? 'selected' : null ?>><?= $s['nama_satuan'] ?></option>
        <?php } ?>
    </select>
    <div id="satuan"></div>
</div>
<div class="form-group">
    <label class="required">Harga</label>
    <input type="text" name="harga" id="harga" class="form-control" placeholder="Harga" value="<?= rupiah($data['harga_detail']) ?>">
</div>
<div class="form-group">
    <label class="required">Jumlah</label>
    <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah" value="<?= rupiah($data['jumlah_detail']) ?>">
</div>
<script>
    $(function() {
        $('.select2').select2();

        $('#harga').keyup(function(e) {
            var nilai = formatted($(this).val(), '');
            $(this).val(nilai);
        });
        $('#jumlah').keyup(function(e) {
            var nilai = formatted($(this).val(), '');
            $(this).val(nilai);
        });
    });
</script>