<?php if ($jenis == 2) : ?>
    <div class="form-group">
        <label>Gudang</label>
        <select name="gudang" id="gudang" class="form-control">
            <option value="">Pilih</option>
            <?php foreach ($data as $d) { ?>
                <option value="<?= $d['id_gudang'] ?>"><?= $d['nama_gudang'] ?></option>
            <?php } ?>
        </select>
    </div>
<?php endif; ?>