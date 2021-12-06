<div class="detail-card m-b-1">
    <div class="detail-body">
        <div class="detail-header">
            <h4><?= $data['nomor']; ?></h4>
            <h5><span class="me-1">Pemasok: <?= $data['pemasok']; ?></span><span class="detail-date pull-right"><i class="fa fa-clock-o"></i> <?= $data['tanggal'] ?></span>
            </h5>
        </div>
        <div class="detail-item with-border">
            <div class="item-title">Harga beli
                <span class="pull-right"><?= $data['hargabeli'] . ' / ' . $data['satuan1']; ?></span>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="idharga" value="<?= $data['idharga'] ?>">
<input type="hidden" name="iddetail_terima" value="<?= $data['iddetail_terima'] ?>">
<input type="hidden" name="nourut" value="<?= $nourut ?>">
<div class="row m-t-1">
    <div class="col-xs-6">
        <div class="checkbox icheck">
            <label>
                <input type="checkbox" name="default" <?= $data['default'] == 1 ? 'checked' : '' ?>> Harga Default
            </label>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="checkbox icheck">
            <label>
                <input type="checkbox" name="aktif" <?= $data['aktif'] == 1 ? 'checked' : '' ?>> Harga Aktif
            </label>
        </div>
    </div>
</div>
<div class="form-group">
    <label>Jumlah Produk</label>
    <div class="input-group">
        <input type="text" name="jumlah" id="jumlah_produk" class="form-control" value="<?= currency_decimal($data['jumlah']) ?>">
        <span class="input-group-addon">/ <?= $data['satuan2'] ?></span>
    </div>
    <div id="jumlah"></div>
</div>
<div class="form-group">
    <label>Harga Jual</label>
    <input type="text" name="harga" id="harga" class="form-control" value="<?= currency_decimal($data['harga']) ?>">
</div>
<script>
    $(document).ready(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    });
    $(function() {
        $('#jumlah_produk').keyup(function(e) {
            var nilai = formatted($(this).val(), '');
            $(this).val(nilai);
        });
        $('#harga').keyup(function(e) {
            var nilai = formatted($(this).val(), '');
            $(this).val(nilai);
        });
    });
</script>