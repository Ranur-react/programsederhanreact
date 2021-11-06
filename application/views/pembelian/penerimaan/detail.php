@section(content)
<?php if ($data['status'] == false) : ?>
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-widget">
            <div class="box-header with-border">
                <h3 class="box-title"><a href="<?= site_url('penerimaan') ?>" class="text-back" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Kembali ke daftar penerimaan</h3>
            </div>
            <div class="box-body">
                <div class="css-nodata">
                    <h1 data-unify="Typography" class="css-nodata-title">Data tidak ditemukan!</h1>
                    <p data-unify="Typography" class="css-nodata-desc">Coba ulangi pencarian anda atau masukkan kata kunci baru</p>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
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
                                        <div class="col-md-2"><b>Nomor</b> <span class="value">:</span></div>
                                        <div class="col-md-10"><?= $data['nomor'] ?></div>
                                        <div class="col-md-2"><b>Tanggal Terima</b> <span class="value">:</span></div>
                                        <div class="col-md-10"> <?= $data['tanggalText'] ?></div>
                                        <div class="col-md-2"><b>Pemasok</b> <span class="value">:</span></div>
                                        <div class="col-md-10"><?= $data['pemasok'] ?></div>
                                        <div class="col-md-2"><b>Gudang</b> <span class="value">:</span></div>
                                        <div class="col-md-10"><?= $data['gudang'] ?></div>
                                        <div class="col-md-2"><b>Status</b> <span class="value">:</span></div>
                                        <div class="col-md-10"><?= $data['statusText'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable table-hover nowrap no-footer">
                            <thead class="bg-gray color-palette">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-right">Jumlah</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['dataProduk'] as $b) { ?>
                                    <tr>
                                        <td><?= $b['produk'] ?></td>
                                        <td class="text-right"><?= $b['jumlahText'] . ' ' . $b['satuan'] ?></td>
                                        <td class="text-right">Rp <?= $b['hargaText'] ?></td>
                                        <td class="text-right">Rp <?= $b['subtotalText'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total</th>
                                    <th class="text-right">Rp <?= $data['totalFormat'] ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <a href="<?= site_url('penerimaan/edit/' . $data['idterima']) ?>" class="btn btn-primary"><i class="icon-pencil7"></i> Edit Penerimaan</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
@endsection