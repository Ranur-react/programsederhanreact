<div class="form-group">
    <label class="required">Pilih Barang</label>
    <select class="form-control select2 barang" name="barang" style="width: 100%;" data-placeholder="Pilh Barang">
        <option></option>
        <?php foreach ($barang as $b) { ?>
            <option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?></option>
        <?php } ?>
    </select>
    <div id="barang"></div>
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
    <input type="text" name="harga" id="harga" class="form-control" placeholder="Harga">
</div>
<div class="form-group">
    <label class="required">Jumlah</label>
    <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah">
</div>