<div class="col-xs-12">
    <?= form_open('#', ['id' => 'form_create'], ['kode' => $data['id']]) ?>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#umum" data-toggle="tab">Umum</a></li>
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