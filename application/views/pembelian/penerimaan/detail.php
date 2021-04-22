<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><a href="<?= site_url('penerimaan') ?>" class="text-back" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Detail Penerimaan Barang</h3>
            </div>
            <div class="box-body">
                <div class="panel panel-default m-y-1">
                    <div class="panel-body panel-body-custom">
                        <div class="row">
                            <div class="col-lg-12 col-xs-12 ">
                                <div class="row">
                                    <div class="col-lg-3 col-xs-4"><b>No Terima</b> <span class="value">:</span></div>
                                    <div class="col-lg-9 col-xs-8"><?= $data['id_terima'] ?></div>
                                    <div class="col-lg-3 col-xs-4"><b>Tanggal Terima</b> <span class="value">:</span></div>
                                    <div class="col-lg-9 col-xs-8"> <?= format_indo($data['tanggal_terima']) ?></div>
                                    <div class="col-lg-3 col-xs-4"><b>Supplier</b> <span class="value">:</span></div>
                                    <div class="col-lg-9 col-xs-8"><?= $data['nama_supplier'] ?></div>
                                    <div class="col-lg-3 col-xs-4"><b>Gudang</b> <span class="value">:</span></div>
                                    <div class="col-lg-9 col-xs-8"><?= $data['nama_gudang'] ?></div>
                                    <div class="col-lg-3 col-xs-4"><b>Status</b> <span class="value">:</span></div>
                                    <div class="col-lg-9 col-xs-8"><?= status_label($data['status_terima'], 'penerimaan') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered dataTable table-hover nowrap no-footer">
                        <thead class="bg-gray color-palette">
                            <tr>
                                <th>Barang</th>
                                <th class="text-right">Harga</th>
                                <th class="text-right">Jumlah</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0;
                            foreach ($barang as $b) {
                                $total = $total + ($b['harga_detail'] * $b['jumlah_detail']);
                            ?>
                                <tr>
                                    <td><?= $b['nama_barang'] ?></td>
                                    <td><?= akuntansi($b['harga_detail']) ?></td>
                                    <td class="text-right"><?= rupiah($b['jumlah_detail']) . ' ' . $b['singkatan_satuan'] ?></td>
                                    <td><?= akuntansi($b['harga_detail'] * $b['jumlah_detail']) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total</th>
                                <th><?= akuntansi($total) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                <a href="<?= site_url('penerimaan/edit/' . $data['id_terima']) ?>" class="btn btn-primary"><i class="icon-pencil7"></i> Edit Penerimaan</a>
            </div>
        </div>
    </div>
</div>