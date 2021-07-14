<div class="form-group">
    <label for="tanggal">Tanggal Mulai</label>
    <div class="input-group date">
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        <input type="text" name="awal" class="form-control pull-right datepicker" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y') ?>">
    </div>
</div>
<div class="form-group">
    <label for="tanggal">Tanggal Akhir</label>
    <div class="input-group date">
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        <input type="text" name="akhir" class="form-control pull-right datepicker" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y') ?>">
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
    });
</script>