<table class="table table-bordered dataTable table-hover nowrap no-footer">
    <tr>
        <th class="bg-gray color-palette" width="180px">No Terima</th>
        <td><?= $data['id_terima'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Supplier</th>
        <td><?= $data['nama_supplier'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Tanggal Terima</th>
        <td><?= format_indo($data['tanggal_terima']) ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Gudang</th>
        <td><?= $data['nama_gudang'] ?></td>
    </tr>
    <tr>
        <th class="bg-gray color-palette">Status</th>
        <td><?= status_label($data['status_terima'], 'penerimaan') ?></td>
    </tr>
</table>
<div class="table-responsive">
    <table class="table table-bordered dataTable table-hover nowrap no-footer">
        <thead class="bg-gray color-palette">
            <tr>
                <th>Barang</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0;
            foreach ($barang as $b) {
                $total = $total + ($b['harga_detail'] * $b['jumlah_detail']);
            ?>
                <tr>
                    <td><?= $b['nama_barang'] ?></td>
                    <td><?= akuntansi($b['harga_detail']) ?></td>
                    <td class="text-right"><?= rupiah($b['jumlah_detail']) . ' ' . $b['singkatan_satuan'] ?></td>
                    <td><?= akuntansi($b['harga_detail'] * $b['jumlah_detail']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total</th>
                <th><?= akuntansi($total) ?></th>
            </tr>
        </tfoot>
    </table>
</div>