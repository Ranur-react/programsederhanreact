<div class="panel panel-default">
    <div class="panel-body panel-body-custom">
        <div class="row">
            <div class="col-lg-12 col-xs-12 ">
                <div class="row">
                    <div class="col-lg-2 col-xs-4"><b>Produk</b> <span class="value">:</span></div>
                    <div class="col-lg-10 col-xs-8"><?= $data['nama_barang'] ?></div>
                    <div class="col-lg-2 col-xs-4"><b>Satuan</b> <span class="value">:</span></div>
                    <div class="col-lg-10 col-xs-8"><?= $data['nama_satuan'] ?></div>
                    <div class="col-lg-2 col-xs-4"><b>Harga</b> <span class="value">:</span></div>
                    <div class="col-lg-10 col-xs-8"><?= currency($data['harga_detail']) ?></div>
                    <div class="col-lg-2 col-xs-4"><b>Jumlah</b> <span class="value">:</span></div>
                    <div class="col-lg-10 col-xs-8"><?= number_decimal($data['jumlah_detail']) . ' ' . $data['singkatan_satuan'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="idterima" value="<?= $terima['idterima'] ?>">
<input type="hidden" name="iddetail" value="<?= $data['id_detail'] ?>">
<input type="hidden" name="idrequest" value="<?= $data['permintaan_detail'] ?>">
<input type="hidden" name="idsatuan" value="<?= $data['id_satuan'] ?>">
<div class="form-group">
    <label class="required">Harga</label>
    <input type="text" name="harga" id="harga" class="form-control" placeholder="Harga" value="<?= number_decimal($data['harga_detail']) ?>" autocomplete="off">
</div>
<div class="form-group">
    <label class="required">Jumlah</label>
    <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah" value="<?= number_decimal($data['jumlah_detail']) ?>" autocomplete="off">
</div>
<script>
    $(function() {
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