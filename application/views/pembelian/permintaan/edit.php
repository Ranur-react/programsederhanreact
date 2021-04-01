<div class="col-md-10 col-md-offset-1">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('permintaan') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Edit Permintaan Barang
            </h3>
        </div>
        <?= form_open('permintaan/update', ['id' => 'form_create']) ?>
        <input type="hidden" name="kode" id="kode" value="<?= $data['id_permintaan'] ?>">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width="40px">No</th>
                            <th>Barang</th>
                            <th class="text-right">Harga</th>
                            <th class="text-right">Jumlah</th>
                            <th class="text-right">Total</th>
                            <th class="text-center" width="60px">
                                <a href="javascript:void(0)" title="Tambah Barang"><i class="fa fa-plus-circle text-primary fa-lg"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="data_tmp"></tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tanggal" class="form-control pull-right datepicker" placeholder="dd-mm-yyyy" value="<?= format_biasa($data['tanggal_permintaan']) ?>">
                        </div>
                        <div id="tanggal"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="pemasok">Pilih Supplier</label>
                        <select class="form-control select2" name="supplier" data-placeholder="Pilih Supplier" style="width: 100%;">
                            <option value=""></option>
                            <?php foreach ($supplier as $s) { ?>
                                <option value="<?= $s['id_supplier'] ?>" <?= $data['supplier_permintaan'] == $s['id_supplier'] ? 'selected' : null ?>><?= $s['nama_supplier'] ?></option>
                            <?php } ?>
                        </select>
                        <div id="supplier"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-floppy-disk"></i> Edit Permintaan</button>
            <a href="javascript:void(0)" class="btn btn-danger"><i class="icon-cross2"></i> Batalkan Permintaan</a>
        </div>
        <?= form_close() ?>
    </div>
</div>