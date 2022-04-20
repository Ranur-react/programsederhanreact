@section(style)
<link rel="stylesheet" href="<?= assets() ?>plugins/bootstrap-fileinput/fileinput.min.css">
@endsection
@section(content)
<div class="col-xs-12">
    <?= form_open('produk/update', ['id' => 'form_create'], ['kode' => $data['id']]) ?>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#umum" data-toggle="tab">Umum</a></li>
            <li><a href="#deskripsi" data-toggle="tab">Deskripsi Barang</a></li>
            <li><a href="#kategori" data-toggle="tab">Kategori & Satuan</a></li>
            <li><a href="#gambar" data-toggle="tab">Gambar</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="umum">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama'] ?>">
                </div>
                <div class="form-group">
                    <label>Slug Barang</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="<?= $data['slug'] ?>">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" <?= $data['status'] == '1' ? 'selected' : null ?>>Enabled</option>
                        <option value="2" <?= $data['status'] == '2' ? 'selected' : null ?>>Disabled</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Referensi Pemasok</label>
                    <select class="form-control select2" multiple="multiple" name="pemasok[]" data-placeholder="Pilih pemasok" style="width: 100%;">
                        <?php foreach ($pemasok as $p) { ?>
                            <option value="<?= $p['id_supplier'] ?>" <?= in_array($p['id_supplier'], array_column($data['dataPemasok'], 'idPemasok')) ? "selected" : null ?>><?= $p['nama_supplier'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="tab-pane" id="deskripsi">
                <div class="table-responsive">
                    <table id="attribute" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-left" style="width: 20%;">Judul</td>
                                <td class="text-left">Deskripsi</td>
                                <td style="width: 5%;"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                            foreach ($data['dataDesc'] as $produk_desc) { ?>
                                <tr id="deskripsi-row<?= $no ?>">
                                    <td class="text-left">
                                        <input type="text" name="produk_desc[<?= $no ?>][name]" placeholder="Judul" class="form-control" value="<?= $produk_desc['judul'] ?>" <?= $produk_desc['level'] == 0 ? 'readonly' : null  ?>>
                                        <input type="hidden" name="produk_desc[<?= $no ?>][attribute_id]" value="<?= $no ?>" />
                                    </td>
                                    <td class="text-left">
                                        <textarea name="produk_desc[<?= $no ?>][produk_desc_desc][text]" rows="5" placeholder="Deskripsi" class="form-control editor"><?= $produk_desc['desc'] ?></textarea>
                                    </td>
                                    <td class="text-right">
                                        <?php if ($produk_desc['level'] != 0) : ?>
                                            <button type="button" onclick="$('#deskripsi-row<?= $no ?>').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php $no++;
                            } ?>
                            <input type="hidden" name="nomor" value="<?= $no ?>">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-right">
                                    <button type="button" onclick="createDeksripsi();" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="kategori">
                <div class="row">
                    <div class="col col-md-6">
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" name="kategori" value="" placeholder="Kategori" id="input-kategori" class="form-control">
                            <div id="produk-kategori" class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php foreach ($data['dataKategori'] as $barang_kategori) { ?>
                                    <div id="produk-kategori<?= $barang_kategori['idKategori'] ?>"><i class="fa fa-minus-circle text-red"></i> <?= $barang_kategori['kategori'] ?><input type="hidden" name="produk_kategori[]" value="<?= $barang_kategori['idKategori'] ?>"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6">
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" name="satuan" value="" placeholder="Satuan" id="input-satuan" class="form-control">
                            <div id="produk-satuan" class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php foreach ($data['dataSatuan'] as $produk_satuan) { ?>
                                    <div id="produk-satuan<?= $produk_satuan['idSatuan'] ?>"><i class="fa fa-minus-circle text-red"></i> <?= $produk_satuan['satuan'] ?><input type="hidden" name="produk_satuan[]" value="<?= $produk_satuan['idSatuan'] ?>"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="gambar">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-left" style="width: 20%;">Satuan</td>
                                <td class="text-left">Gambar</td>
                                <td style="width: 5%;" class="text-center">
                                    <a href="javascript:void(0)" onclick="createGambar()">
                                        <i class="icon-plus-circle2 text-blue" title="Tambah Gambar"></i>
                                    </a>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="bodygambar" style="cursor: all-scroll;"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-success" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-floppy-disk"></i> Simpan</button>
            <a href="<?= site_url('produk') ?>" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
        </div>
    </div>
    <?= form_close() ?>
</div>
<div id="tampil_modal"></div>
@endsection
@section(script)
<script src="<?= assets() ?>plugins/bootstrap-fileinput/fileinput.min.js"></script>
<script src="<?= assets() ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= assets_js() ?>common.js"></script>
<script src="<?= assets_js() ?>katalog/produk/edit.js"></script>
@endsection