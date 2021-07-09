<div class="panel panel-default">
    <div class="panel-body panel-body-custom">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-3 col-xs-4"><b>Nomor</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8"><?= $data['nosurat_terima'] ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Tanggal Terima</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8"><?= format_indo($data['tanggal_terima']) ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Supplier</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8"><?= $data['nama_supplier'] ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Total</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8">Rp. <?= rupiah($data['total_terima']); ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Total Bayar</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8">Rp. <?= rupiah($bayar['bayar']) ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Sisa Bayar</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8">Rp. <?= rupiah($bayar['sisa']) ?></div>
                    <div class="col-lg-3 col-xs-4"><b>Status</b><span class="value">:</span></div>
                    <div class="col-lg-9 col-xs-8"><?= status_label($data['status_terima'], 'penerimaan') ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="idterima" value="<?= $data['id_terima']; ?>">
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
    <textarea name="keterangan" id="keterangan" class="form-control" rows="5"></textarea>
</div>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
    });
    $('#jumlah').keyup(function(e) {
        var nilai = formatRupiah($(this).val(), '');
        $(this).val(nilai);
    });
</script>