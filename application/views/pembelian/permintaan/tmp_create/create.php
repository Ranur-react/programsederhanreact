<div class="form-group">
    <label class="required">Pilih Produk</label>
    <select class="form-control select2 idproduk" name="produk" style="width: 100%;" data-placeholder="Pilh Produk">
        <option></option>
        <?php foreach ($produk as $p) { ?>
            <option value="<?= $p['id_barang'] ?>"><?= $p['nama_barang'] ?></option>
        <?php } ?>
    </select>
    <div id="produk"></div>
</div>
<div class="form-group">
    <label class="required">Pilih Satuan</label>
    <select class="form-control select2 satuan" name="satuan" style="width: 100%;" data-placeholder="Pilh Satuan">
        <option></option>
    </select>
    <div id="satuan"></div>
</div>
<div class="form-group">
    <label class="required">Harga</label>
    <input type="text" name="harga" id="harga" class="form-control" placeholder="Harga" autocomplete="off">
</div>
<div class="form-group">
    <label class="required">Jumlah</label>
    <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah" autocomplete="off">
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