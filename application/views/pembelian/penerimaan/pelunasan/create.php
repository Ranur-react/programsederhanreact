<div class="panel panel-default">
    <div class="panel-body panel-body-custom">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-3 col-xs-4"><b>Nomor</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8"><?= $data['nomor'] ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Tanggal Terima</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8"><?= $data['tanggalText'] ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Pemasok</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8"><?= $data['pemasok'] ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Total Tagihan</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8">Rp. <?= $data['totalText'] ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Pembayaran</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8">Rp. <?= $data['totalBayarFormat'] ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Sisa Bayar</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8">Rp. <?= $data['sisaBayarFormat'] ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Status</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8"><?= $data['statusText'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="idterima" value="<?= $data['idterima']; ?>">
<div class="form-group">
    <label for="nama">Tanggal Bayar</label>
    <div class="input-group date">
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        <input type="text" name="tanggal" class="form-control pull-right datepicker" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y') ?>">
    </div>
    <div id="tanggal"></div>
</div>
<div class="form-group">
    <label for="nama">Jumlah Bayar</label>
    <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah Bayar">
</div>
<div class="form-group">
    <label for="nama">Keterangan</label>
    <textarea name="note" id="note" class="form-control" rows="5"></textarea>
</div>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
    });
    $('#jumlah').keyup(function(e) {
        var nilai = formatted($(this).val(), '');
        $(this).val(nilai);
    });
</script>