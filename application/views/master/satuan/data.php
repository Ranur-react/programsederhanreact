<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <button class="btn btn-social btn-flat btn-success btn-sm" onclick="tambah()"><i class="icon-plus3"></i> Tambah <?= $title ?></button>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="data-tabel">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th>Nama</th>
                        <th>Singkatan</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($data as $d) { ?>
                        <tr>
                            <td class="text-center" width="40px"><?= $no . '.'; ?></td>
                            <td><?= $d['nama_satuan'] ?></td>
                            <td><?= $d['singkatan_satuan'] ?></td>
                            <td class="text-center" width="60px">
                                <a href="javascript:void(0)" onclick="edit('<?= $d['id_satuan'] ?>')">
                                    <i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="hapus('<?= $d['id_satuan'] ?>')">
                                    <i class="icon-trash text-red" data-toggle="tooltip" data-original-title="Hapus"></i>
                                </a>
                            </td>
                        </tr>
                    <?php $no++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>