<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <button class="btn btn-social btn-flat btn-success btn-sm"><i class="icon-plus3"></i> Tambah <?= $title ?></button>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="data-tabel">
                <thead>
                    <tr>
                        <th class="text-center" width="40px">No.</th>
                        <th>Barang</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($data as $d) { ?>
                        <tr>
                            <td class="text-center"><?= $no . '.' ?></td>
                            <td><?= $d['nama_barang'] ?></td>
                            <td width="120px">
                                <span class="label status <?= $d['status_barang'] == 1 ? 'status-active' : 'status-unpaid' ?>"><?= $d['status_barang'] == 1 ? 'Enabled' : 'Disabled' ?></span>
                            </td>
                            <td class="text-center" width="60px">
                                <a href="javascript:void(0)">
                                    <i class="icon-pencil7 text-green" data-toggle="tooltip" data-original-title="Edit"></i>
                                </a>
                                <a href="javascript:void(0)">
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