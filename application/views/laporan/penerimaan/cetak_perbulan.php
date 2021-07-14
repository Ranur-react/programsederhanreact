<table class="tabel-header" style="border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 15px;">
    <tr>
        <td>Bulan : <?= bulan($bulan) . ' ' . $tahun ?></td>
    </tr>
</table>
<?php if ($data == null) : ?>
    <table class="tabel-header">
        <tr>
            <td align="center">Data Penerimaan Barang Perbulan Tidak Ditemukan</td>
        </tr>
    </table>
<?php else : ?>
    <?php foreach ($data as $value) { ?>
        <table class="tabel-header">
            <tr>
                <td width="130px">No. Terima</td>
                <td width="10px" align="center">:</td>
                <td><?= $value['nomor'] ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td align="center">:</td>
                <td><?= format_indo($value['tanggal']) ?></td>
            </tr>
            <tr>
                <td>Supplier</td>
                <td align="center">:</td>
                <td><?= $value['supplier'] ?></td>
            </tr>
            <tr>
                <td>Gudang</td>
                <td align="center">:</td>
                <td><?= $value['gudang'] ?></td>
            </tr>
        </table>
        <table class="tabel-data">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No.</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
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
                        <td><?= $valueProduk['satuan'] ?></td>
                        <td><?= akuntansi($valueProduk['harga']) ?></td>
                        <td align="right"><?= rupiah($valueProduk['jumlah']) . ' ' . $valueProduk['singkat'] ?></td>
                        <td><?= akuntansi($valueProduk['total']) ?></td>
                    </tr>
                <?php $no++;
                } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" align="right">Total</th>
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
<?php endif; ?>