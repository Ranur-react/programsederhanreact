<?php if ($data['id'] == null) { ?>
    @section(content)
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-widget">
            <div class="box-header with-border">
                <h3 class="box-title"><a href="<?= site_url('permintaan') ?>" class="text-back" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Kembali ke daftar permintaan</h3>
            </div>
            <div class="box-body">
                <div class="css-nodata">
                    <h1 data-unify="Typography" class="css-nodata-title">Data tidak ditemukan!</h1>
                    <p data-unify="Typography" class="css-nodata-desc">Coba ulangi pencarian anda atau masukkan kata kunci baru</p>
                </div>
            </div>
        </div>
    </div>
    @endsection
<?php } else { ?>
    @section(style)
    <link rel="stylesheet" href="<?= assets() ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?= assets() ?>plugins/toastr/toastr.min.css">
    @endsection
    @section(content)
    <div class="col-md-10 col-md-offset-1">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a class="text-back" href="<?= site_url('permintaan') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Edit Permintaan Produk
                </h3>
            </div>
            <?= form_open('permintaan/update', ['id' => 'form_create'], ['kode' => $data['id']]) ?>
            <div class="box-body">
                <div class="panel panel-default m-y-1">
                    <div class="panel-body panel-body-custom">
                        <div class="row">
                            <div class="col-lg-12 col-xs-12 ">
                                <div class="row">
                                    <div class="col-md-2"><b>Nomor</b> <span class="value">:</span></div>
                                    <div class="col-md-10"><?= $data['nomor'] ?></div>
                                    <div class="col-md-2"><b>Tanggal</b> <span class="value">:</span></div>
                                    <div class="col-md-10"><?= $data['tanggal_format'] ?></div>
                                    <div class="col-md-2"><b>Status</b> <span class="value">:</span></div>
                                    <div class="col-md-10"><?= $data['status_label'] ?></div>
                                    <div class="col-md-2"><b>User</b> <span class="value">:</span></div>
                                    <div class="col-md-10"><?= $data['user'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" width="40px">No</th>
                                <th>Produk</th>
                                <th class="text-right">Harga</th>
                                <th class="text-right">Jumlah</th>
                                <th class="text-right">Total</th>
                                <th class="text-center" width="60px">
                                    <a href="javascript:void(0)" onclick="create()" title="Tambah"><i class="fa fa-plus-circle text-primary fa-lg"></i></a>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="data_tmp"></tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" name="tanggal" class="form-control pull-right datepicker" placeholder="dd-mm-yyyy" value="<?= $data['tanggal_date'] ?>" readonly>
                            </div>
                            <div id="tanggal"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-floppy-disk"></i> Edit Permintaan</button>
                <a href="javascript:void(0)" class="btn btn-danger" onclick="batal()"><i class="icon-cross2"></i> Batalkan Permintaan</a>
            </div>
            <?= form_close() ?>
        </div>
    </div>
    <div id="tampil_modal"></div>
    @endsection
    @section(script)
    <script src="<?= assets() ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= assets() ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?= assets() ?>plugins/toastr/toastr.min.js"></script>
    <script src="<?= assets_js() ?>common.js"></script>
    <script src="<?= assets_js() ?>pembelian\permintaan\edit.js"></script>
    @endsection
<?php } ?>