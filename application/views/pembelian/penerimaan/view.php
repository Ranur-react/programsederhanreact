<table class="table table-bordered dataTable table-hover nowrap no-footer">
    <tr>
        <th class="bg-gray color-palette" width="180px">Nomor</th>
        <td><?= $data['nomor'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Tanggal Terima</th>
        <td><?= $data['tanggalText'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Pemasok</th>
        <td><?= $data['pemasok'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Gudang</th>
        <td><?= $data['gudang'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Status</th>
        <td><?= $data['statusText'] ?></td>
    </tr>
</table>
<div class="table-responsive">
    <table class="table table-bordered dataTable table-hover nowrap no-footer">
        <thead class="bg-gray color-palette">
            <tr>
                <th>Produk</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['dataProduk'] as $b) { ?>
                <tr>
                    <td><?= $b['produk'] ?></td>
                    <td class="text-right"><?= $b['jumlahText'] . ' ' . $b['satuan'] ?></td>
                    <td class="text-right">Rp <?= $b['hargaText'] ?></td>
                    <td class="text-right">Rp <?= $b['subtotalText'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total</th>
                <th class="text-right">Rp <?= $data['totalFormat'] ?></th>
            </tr>
        </tfoot>
    </table>
</div>