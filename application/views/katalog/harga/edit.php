<div class="detail-card m-b-1">
    <div class="detail-body">
        <div class="detail-header">
            <h4><?= $data['barang']; ?></h4>
            <h5><span class="me-1"><?= $data['nomor']; ?></span><span class="me-1"><?= $data['tanggal']; ?></span>dari: Supplier 1 <span class="detail-date pull-right"><i class="fa fa-clock-o"></i> <?= $data['created_at'] ?></span>
            </h5>
        </div>
        <div class="detail-item with-border">
            <div class="item-title">Harga beli
                <span class="pull-right"><?= $data['harga_beli'] . ' ' . $data['satuan_beli']; ?></span>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="idharga" value="<?= $data['id_harga'] ?>">
<input type="hidden" name="iddetail" value="<?= $data['id_detail'] ?>">
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
    <label>Berat</label>
    <div class="input-group">
        <input type="text" name="berat" id="keyberat" class="form-control" value="<?= $data['berat']; ?>">
        <span class="input-group-addon"><?= $data['satuan_jual']; ?></span>
    </div>
    <div id="berat"></div>
</div>
<div class="form-group">
    <label>Harga Jual</label>
    <input type="text" name="harga" id="harga" class="form-control" value="<?= $data['harga'] ?>">
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
        $('#keyberat').keyup(function(e) {
            var nilai = formatRupiah($(this).val(), '');
            $(this).val(nilai);
        });
        $('#harga').keyup(function(e) {
            var nilai = formatRupiah($(this).val(), '');
            $(this).val(nilai);
        });
    });
</script>