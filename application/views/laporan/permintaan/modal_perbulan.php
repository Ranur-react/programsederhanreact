<div class="form-group">
    <label for="tanggal">Pilih Bulan</label>
    <select class="form-control" name="bulan">
        <option value="">-- Pilih Bulan --</option>
        <?php
        $nama_bln = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        for ($bln = 1; $bln <= 12; $bln++) {
            echo "<option value=$bln>$nama_bln[$bln]</option>";
        }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="tanggal">Pilih Tahun</label>
    <select class="form-control" name="tahun">
        <option value="">-- Pilih Tahun --</option>
        <?php
        $now = date('Y');
        for ($a = 2020; $a <= $now; $a++) {
            echo "<option value='$a'>$a</option>";
        } ?>
    </select>
</div>