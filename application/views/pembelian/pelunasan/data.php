<div class="panel panel-default m-y-1">
    <div class="panel-body panel-body-custom">
        <div class="row">
            <div class="col-lg-12 col-xs-12 ">
                <div class="row">
                    <div class="col-md-2"><b>Nomor</b><span class="value">:</span></div>
                    <div class="col-md-4"><?= $data['nosurat_terima'] ?></div>
                    <div class="col-md-2"><b>Total</b><span class="value">:</span></div>
                    <div class="col-md-4">Rp. <?= rupiah($data['total_terima']); ?></div>
                    <div class="col-md-2"><b>Tanggal Terima</b><span class="value">:</span></div>
                    <div class="col-md-4"><?= format_indo($data['tanggal_terima']) ?></div>
                    <div class="col-md-2"><b>Total Bayar</b><span class="value">:</span></div>
                    <div class="col-md-4">Rp. <?= rupiah($bayar['bayar']) ?></div>
                    <div class="col-md-2"><b>Supplier</b><span class="value">:</span></div>
                    <div class="col-md-4"><?= $data['nama_supplier'] ?></div>
                    <div class="col-md-2"><b>Sisa Bayar</b><span class="value">:</span></div>
                    <div class="col-md-4">Rp. <?= rupiah($bayar['sisa']) ?></div>
                    <div class="col-md-2"><b>Status</b><span class="value">:</span></div>
                    <div class="col-md-10"><?= status_label($data['status_terima'], 'penerimaan') ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="4">Histori Pelunasan Penerimaan</th>
            <td class="text-center">
                <a href="javascript:void(0)" onclick="create('<?= $data['id_terima']; ?>')"><i class="icon-plus-circle2 text-blue" title="Tambah"></i></a>
            </td>
        </tr>
        <tr>
            <th class="text-center" width="40px">No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th class="text-right">Jumlah</th>
            <th class="text-center" width="60px">#</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        $total = 0;
        foreach ($result as $rows) {
            $total = $total + $rows['nominal']
        ?>
            <tr>
                <td class="text-center"><?= $no; ?></td>
                <td><?= $rows['tanggal']; ?></td>
                <td><?= $rows['info']; ?></td>
                <td class="text-right"><?= $rows['jumlah']; ?></td>
                <td class="text-center">
                    <a href="javascript:void(0)" onclick="destroy('<?= $rows['id_bayar']; ?>')"><i class="icon-trash text-red" title="Hapus"></i></a>
                </td>
            </tr>
        <?php $no++;
        } ?>
        <tr>
            <th colspan="3" class="text-right">Total</th>
            <th class="text-right"><?= rupiah($total) ?></th>
            <td></td>
        </tr>
    </tbody>
</table>