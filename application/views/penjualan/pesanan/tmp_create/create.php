<div class="form-group">
    <label class="required">Pilih Barang</label>
    <select class="form-control select2 idbarang" name="barang" style="width: 100%;" data-placeholder="Pilih Barang">
        <option></option>
        <?php foreach ($barang as $b) { ?>
            <option value="<?= $b['id'] ?>"><?= $b['barang'] ?></option>
        <?php } ?>
    </select>
    <div id="barang"></div>
</div>
<div id="list-penerimaan"></div>
<div class="form-group">
    <label class="required">Jumlah</label>
    <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah">
</div>
<script>
    $(function() {
        $('.select2').select2();
        $('#jumlah').keyup(function(e) {
            var nilai = formatRupiah($(this).val(), '');
            $(this).val(nilai);
        });
    });
</script>