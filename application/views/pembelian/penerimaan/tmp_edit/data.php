<?php if (empty($data)) :
    echo '<tr><td colspan="8" class="text-center text-red">Belum ada data barang yang diinputkan.</td></tr>';
else :
    $no = 1;
    $total = 0;
    foreach ($data as $d) {
        $total = $total + ($d['harga_terima'] * $d['jumlah_terima']);
?>
        <tr>
            <td class="text-center"><?= $no . '.' ?></td>
            <td><?= $d['nama_barang'] ?></td>
            <td><?= akuntansi($d['harga_terima']) ?></td>
            <td class="text-right"><?= rupiah($d['jumlah_terima']) . ' ' . $d['singkatan_satuan'] ?></td>
            <td><?= akuntansi($d['harga_terima'] * $d['jumlah_terima']) ?></td>
            <td class="text-center">
                <a href="javascript:void(0)" onclick="edit('<?= $d['id_detail_terima'] ?>')"><i class="icon-pencil7 text-green" title="Edit Data"></i></a>
                <a href="javascript:void(0)" onclick="destroy('<?= $d['id_detail_terima'] ?>')"><i class="icon-trash text-red" title="Hapus Data"></i></a>
            </td>
        </tr>
    <?php $no++;
    } ?>
    <tr>
        <th colspan="4" class="text-right">Total</th>
        <th class="text-right"><?= akuntansi($total) ?></th>
        <td></td>
    </tr>
<?php endif ?>