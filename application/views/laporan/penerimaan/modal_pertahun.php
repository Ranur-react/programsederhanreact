<div class="form-group">
    <label for="tanggal">Pilih Tahun</label>
    <select class="form-control" name="tahun">
        <option value="">-- Pilih Tahun --</option>
        <?php
        $now = date('Y');
        for ($a = 2021; $a <= $now; $a++) {
            echo "<option value='$a'>$a</option>";
        } ?>
    </select>
</div>