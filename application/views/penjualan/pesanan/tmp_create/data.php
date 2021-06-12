<?php if (empty($data)) :
    echo '<tr><td colspan="8" class="text-center text-red">Belum ada data barang yang diinputkan.</td></tr>';
else :
    $no = 1;
    foreach ($data['data'] as $d) { ?>
        <tr>
            <td class="text-center"><?= $no . '.' ?></td>
            <td><?= $d['barang'] ?></td>
            <td>
                <?= $d['nomor'] ?>
                <div class="text-muted text-size-small"><i class="fa fa-calendar"></i> <?= format_biasa($d['tanggal']) ?></div>
            </td>
            <td><?= akuntansi($d['harga']) ?></td>
            <td class="text-right"><?= rupiah($d['jumlah']) . ' ' . $d['satuan'] ?></td>
            <td><?= akuntansi($d['total']) ?></td>
            <td class="text-center">
                <a href="javascript:void(0)" onclick="destroy('<?= $d['id'] ?>')"><i class="icon-trash text-red" title="Hapus Data"></i></a>
            </td>
        </tr>
    <?php $no++;
    } ?>
    <tr>
        <th colspan="5" class="text-right">Total</th>
        <th class="text-right"><?= akuntansi($data['total']) ?></th>
        <td></td>
    </tr>
<?php endif ?>