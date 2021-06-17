<input type="hidden" name="idkirim" value="<?= $data['id_kirim'] ?>">
<input type="hidden" name="idorder" value="<?= $pesanan['id'] ?>">
<input type="hidden" name="idbayar" value="<?= $pesanan['idbayar'] ?>">
<input type="hidden" name="idmetode" value="<?= $pesanan['idmetode'] ?>">
<table class="table table-bordered dataTable table-hover nowrap no-footer">
    <tr>
        <th colspan="2" class="bg-gray color-palette text-center">Detail Pesanan</th>
    </tr>
    <tr>
        <th class="bg-gray color-palette" width="130px">Nomor Invoice</th>
        <td><?= $pesanan['nomor'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Status Bayar</th>
        <td><?= status_label($pesanan['status_bayar'], 'bayar') ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Status Order</th>
        <td><?= status_label($pesanan['status'], 'order') ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Customer</th>
        <td><?= $pesanan['customer'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Tanggal Pembelian</th>
        <td><?= format_indo(format_tglen_timestamp($pesanan['tanggal'])) . ', ' . sort_jam_timestamp($pesanan['tanggal']) ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Metode Bayar</th>
        <td><?= $pesanan['metode'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Total Bayar</th>
        <td><?= 'Rp ' . rupiah($pesanan['total']) ?></td>
    </tr>
</table>
<h4 style="padding: 20px 0px 0px;margin: 20px 0px 0px;border-top: thin solid rgb(224, 224, 224);">Informasi Penerima Pesanan</h4>
<div class="form-group">
    <label>Nama Penerima</label>
    <input type="text" name="nama" id="nama" class="form-control" value="<?= $pesanan['customer'] ?>">
</div>
<div class="form-group">
    <label>Relasi dengan penerima</label>
    <select name="relasi" id="relasi" class="form-control">
        <?php foreach ($relasi as $key => $value) { ?>
            <option value="<?= $key ?>"><?= $value ?></option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label>Catatan</label>
    <textarea class="form-control" name="note"></textarea>
</div>
<?php if ($pesanan['idmetode'] == 1) : ?>
    <div class="form-group">
        <label>Jumlah Bayar</label>
        <input type="text" name="nilai" id="nilai" class="form-control">
    </div>
<?php endif ?>
<script>
    $(document).ready(function() {
        $('#nilai').keyup(function(e) {
            var nilai = formatRupiah($(this).val(), '');
            $(this).val(nilai);
        });
    });
</script>