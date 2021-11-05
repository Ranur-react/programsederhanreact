<table class="table table-bordered dataTable table-hover nowrap no-footer">
    <tr>
        <th class="bg-gray color-palette" width="130px">Nomor</th>
        <td>
            <?= $data['nomor'] ?><div class="separate"></div>
            <a href="<?= site_url('permintaan/print/' . $data['id']) ?>" style="color: rgb(255, 87, 34)" target="_blank">Cetak</a>
        </td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Tanggal</th>
        <td><?= $data['tanggal_format'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Status</th>
        <td><?= $data['status_label'] ?></td>
    </tr>
</table>
<div class="table-responsive">
    <table class="table table-bordered dataTable table-hover nowrap no-footer">
        <thead class="bg-gray color-palette">
            <tr>
                <th>Produk</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['dataProduk'] as $b) { ?>
                <tr>
                    <td><?= $b['produk'] ?></td>
                    <td class="text-right"><?= $b['hargaText'] ?></td>
                    <td class="text-right"><?= $b['jumlahProduk'] ?></td>
                    <td class="text-right"><?= $b['totalText'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total</th>
                <th class="text-right"><?= $data['totalText'] ?></th>
            </tr>
        </tfoot>
    </table>
</div>