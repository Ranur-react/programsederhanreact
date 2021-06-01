<div class="form-group">
    <label>Pilih Bank</label>
    <select class="form-control select2" name="code" data-placeholder="Pilih Bank" style="width: 100%;">
        <option value=""></option>
        <?php foreach ($bank as $b) { ?>
            <option value="<?= $b['id_bank'] ?>"><?= $b['nama_bank'] . ' (' . $b['code_bank'] . ')' ?></option>
        <?php } ?>
    </select>
    <div id="code"></div>
</div>
<div class="form-group">
    <label>Kantor Cabang</label>
    <input type="text" name="cabang" id="cabang" class="form-control">
</div>
<div class="form-group">
    <label>No Rekening</label>
    <input type="text" name="norek" id="norek" class="form-control">
</div>
<div class="form-group">
    <label>Atasnama</label>
    <input type="text" name="holder" id="holder" class="form-control">
</div>
<div class="form-group">
    <label>Pilih Status</label>
    <select class="form-control" name="status" id="status">
        <option value="">--- Pilih ---</option>
        <option value="1">Aktif</option>
        <option value="2">Tidak Aktif</option>
    </select>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>