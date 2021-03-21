<div class="col-xs-12">
    <?= form_open('#', ['id' => 'form_create'], ['kode' => $data['id_barang']]) ?>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#umum" data-toggle="tab">Umum</a></li>
            <li><a href="#kategori" data-toggle="tab">Kategori & Satuan</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="umum">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama_barang'] ?>">
                </div>
                <div class="form-group">
                    <label>Slug Barang</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="<?= $data['slug_barang'] ?>">
                </div>
                <div class="form-group">
                    <label>Deskripsi Barang</label>
                    <textarea class="form-control" name="desc" id="desc" cols="50" rows="10" style="visibility: hidden; display: none;"><?= $data['desc_barang'] ?></textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" <?= $data['status_barang'] == '1' ? 'selected' : null ?>>Enabled</option>
                        <option value="2" <?= $data['status_barang'] == '2' ? 'selected' : null ?>>Disabled</option>
                    </select>
                </div>
            </div>
            <div class="tab-pane" id="kategori">
                <!-- // -->
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-success" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-floppy-disk"></i> Simpan</button>
            <a href="<?= site_url('barang') ?>" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
        </div>
    </div>
    <?= form_close() ?>
</div>