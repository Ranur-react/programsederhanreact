<table class="tabel-data">
    <thead>
        <tr>
            <th>Kode Gudang</th>
            <th>Nama Gudang</th>
            <th>Alamat Gudang</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($data as $d) { ?>
            <tr>
                <td align="center"><?= $d['id_gudang'] ?></td>
                <td><?= $d['nama_gudang'] ?></td>
                <td><?= $d['alamat_gudang'] ?></td>
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