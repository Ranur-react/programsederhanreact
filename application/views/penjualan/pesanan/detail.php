<table class="table table-bordered dataTable table-hover nowrap no-footer">
    <tr>
        <th class="bg-gray color-palette" width="130px">Nomor Invoice</th>
        <td><?= $data['nomor'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Status Bayar</th>
        <td><?= status_label($data['status_bayar'], 'bayar') ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Status Order</th>
        <td><?= status_label($data['status'], 'order') ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Customer</th>
        <td><?= $data['customer'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Tanggal Pembelian</th>
        <td><?= format_indo(format_tglen_timestamp($data['tanggal'])) . ', ' . sort_jam_timestamp($data['tanggal']) ?></td>
    </tr>
</table>
<div class="table-responsive">
    <table class="table table-bordered dataTable table-hover nowrap no-footer">
        <thead class="bg-gray color-palette">
            <tr>
                <th>Daftar Barang</th>
                <th>Harga Barang</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produk['data'] as $p) { ?>
                <tr>
                    <td>
                        <?= $p['produk'] ?>
                        <div class="text-muted text-size-small"><?= rupiah($p['jumlah']) . ' X Rp ' . rupiah($p['harga']) ?></div>
                        <?php if ($p['note'] != null) { ?>
                            <div class="text-muted text-size-small"><?= $p['note'] ?></div>
                        <?php } ?>
                    </td>
                    <td><?= 'Rp ' . rupiah($p['total']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="row invoice-info" style="padding: 20px 0px 0px;margin: 20px 0px 0px;border-top: thin solid rgb(224, 224, 224);">
    <div class="col-sm-6 invoice-col">
        Pengiriman
        <address>
            Dikirim kepada <strong><?= $pengiriman['penerima'] ?></strong><br>
            <?= $pengiriman['alamat'] ?><br>
            <?= $pengiriman['kota'] . ', ' . $pengiriman['pos'] ?><br>
            Telp: <?= $pengiriman['telp'] ?><br>
        </address>
    </div>
    <div class="col-sm-6 invoice-col">
        Pembayaran
        <address>
            Total Harga (<?= count($produk['data']) ?> Item) : <strong><?= 'Rp ' . rupiah($produk['total']) ?></strong><br>
            Total Bayar: <strong><?= 'Rp ' . rupiah($data['total']) ?></strong><br>
            Metode Pembayaran: <strong><?= $data['metode'] ?></strong>
        </address>
    </div>
</div>