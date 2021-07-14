<table class="tabel-header">
    <tr>
        <td>Tahun : <?= $tahun ?></td>
    </tr>
</table>
<table class="tabel-data">
    <thead>
        <tr>
            <th class="text-center" width="5%">No.</th>
            <th align="center">Bulan</th>
            <th align="center">Jumlah Permintaan</th>
            <th align="center">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        $total = 0;
        foreach ($data as $d) {
            $total = $total + $d['total'];
        ?>
            <tr>
                <td align="center"><?= $no ?></td>
                <td><?= $d['bulan'] ?></td>
                <td><?= akuntansi($d['jumlah']) ?></td>
                <td><?= akuntansi($d['total']) ?></td>
            </tr>
        <?php $no++;
        } ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" align="right">Total</th>
            <td><?= akuntansi($total) ?></td>
        </tr>
    </tfoot>
</table>