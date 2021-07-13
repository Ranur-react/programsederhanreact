<?php foreach ($data as $value) { ?>
    <table class="tabel-header">
        <tr>
            <td width="130px">Invoice</td>
            <td width="10px" align="center">:</td>
            <td><?= $value['invoice'] ?></td>
        </tr>
        <tr>
            <td>Tanggal Beli</td>
            <td align="center">:</td>
            <td><?= format_tglin_timestamp($value['tanggal_beli']) ?></td>
        </tr>
        <tr>
            <td>Tanggal Terima</td>
            <td align="center">:</td>
            <td><?= format_tglin_timestamp($value['tanggal_terima']) ?></td>
        </tr>
        <tr>
            <td>Customer</td>
            <td align="center">:</td>
            <td><?= $value['customer'] ?></td>
        </tr>
        <tr>
            <td>Penerima</td>
            <td align="center">:</td>
            <td><?= $value['penerima'] ?></td>
        </tr>
        <tr>
            <td>Relasi</td>
            <td align="center">:</td>
            <td><?= relasi($value['relasi']) ?></td>
        </tr>
    </table>
    <table class="tabel-data">
        <thead>
            <tr>
                <th class="text-center" width="5%">No.</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            $total = 0;
            foreach ($value['produk'] as $valueProduk) {
                $total = $total + $valueProduk['total'];
            ?>
                <tr>
                    <td align="center"><?= $no ?></td>
                    <td><?= $valueProduk['produk'] ?></td>
                    <td><?= akuntansi($valueProduk['harga']) ?></td>
                    <td align="right"><?= rupiah($valueProduk['jumlah']) . ' ' . $valueProduk['singkat'] ?></td>
                    <td><?= akuntansi($valueProduk['total']) ?></td>
                </tr>
            <?php $no++;
            } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" align="right">Total</th>
                <th><?= akuntansi($total) ?></td>
            </tr>
        </tfoot>
    </table>
<?php } ?>
<table class="tabel-footer">
    <tr>
        <td width="80%"></td>
        <td style="border-bottom: none;">
            Padang, <?= format_indo(date('Y-m-d')) ?><br>
            <br><br><br><br><br><br>
            <?= role_user() ?>
        </td>
    </tr>
</table>