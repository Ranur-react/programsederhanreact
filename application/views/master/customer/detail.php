<div class="col-xs-12">
    <?= form_open('#', ['id' => 'form_create'], ['kode' => $data['id']]) ?>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#umum" data-toggle="tab">Umum</a></li>
            <li><a href="#alamat" data-toggle="tab">Alamat</a></li>
            <li><a href="#bank" data-toggle="tab">Akun Bank</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="umum">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama'] ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" id="email" class="form-control" value="<?= $data['email'] ?>">
                </div>
                <div class="form-group">
                    <label>No Ponsel</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="<?= $data['phone'] ?>">
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <div class="input-group date">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" name="birth" class="form-control pull-right datepicker" placeholder="dd-mm-yyyy" value="<?= $data['birth'] != null ? format_biasa($data['birth']) : date('d-m-Y') ?>">
                    </div>
                    <div id="birth"></div>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenkel" id="jenkel" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="1" <?= $data['jenkel'] == 1 ? 'selected' : null ?>>Pria</option>
                        <option value="2" <?= $data['jenkel'] == 2 ? 'selected' : null ?>>Wanita</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" <?= $data['status'] == 1 ? 'selected' : null ?>>Enabled</option>
                        <option value="2" <?= $data['status'] == 2 ? 'selected' : null ?>>Disabled</option>
                    </select>
                </div>
            </div>
            <div class="tab-pane" id="alamat">
                <div class="row">
                    <?php if ($data['dataAlamat'] != null) :
                        foreach ($data['dataAlamat'] as $da) { ?>
                            <div class="col-md-4">
                                <div class="detail-card">
                                    <div class="detail-body<?= $da['utama'] == '1' ? ' active' : '' ?>">
                                        <div class="detail-header-noborder">
                                            <h4><?= $da['penerima'] ?></h4>
                                            <h6><?= $da['telp'] ?></h6>
                                            <h6><?= $da['detail'] ?></h6>
                                            <h6><?= $da['kota'] ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    else :
                        echo '<div class="col-md-12">' . info('belum ada data alamat') . '</div>' ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tab-pane" id="bank">
                <div class="row">
                    <?php if ($data['dataBank'] != null) :
                        foreach ($data['dataBank'] as $db) { ?>
                            <div class="col-md-4">
                                <div class="detail-card">
                                    <div class="detail-body<?= $db['utama'] == '1' ? ' active' : '' ?>">
                                        <div class="detail-header-noborder">
                                            <h4><?= $db['bank'] ?></h4>
                                            <h5><?= $db['norek'] ?><br>a/n <?= $db['pemilik'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    else :
                        echo '<div class="col-md-12">' . info('belum ada data bank') . '</div>' ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-floppy-disk"></i> Simpan</button>
            <a href="<?= site_url('customer') ?>" class="btn btn-danger"><i class="fa fa-angle-double-left"></i> Kembali</a>
        </div>
    </div>
    <?= form_close() ?>
</div>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
    });
</script>