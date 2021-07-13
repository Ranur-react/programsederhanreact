<table class="tabel-data">
    <thead>
        <tr>
            <th class="text-center" width="5%">No.</th>
            <th>Barang</th>
            <th>Kategori</th>
            <th>Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($data as $d) { ?>
            <tr>
                <td align="center"><?= $no ?></td>
                <td><?= $d['produk'] ?></td>
                <td><?= $d['kategori'] ?></td>
                <td align="right"><?= $d['stok'] ?></td>
            </tr>
        <?php $no++;
        } ?>
    </tbody>
</table>
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