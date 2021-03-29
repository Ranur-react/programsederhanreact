<div class="col-md-10 col-md-offset-1">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('popupuk') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Tambah Permintaan Barang
            </h3>
        </div>
        <?= form_open('permintaan/store', ['id' => 'form_create']) ?>
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
                                <a href="javascript:void(0)" onclick="create()" title="Tambah Barang"><i class="fa fa-plus-circle text-primary fa-lg"></i></a>
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
                            <input type="text" name="tanggal" class="form-control pull-right datepicker" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y') ?>">
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
                                <option value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                            <?php } ?>
                        </select>
                        <div id="supplier"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-floppy-disk"></i> Simpan Permintaan</button>
            <a href="javascript:void(0)" class="btn btn-danger" onclick="batal()"><i class="icon-cross2"></i> Batalkan Permintaan</a>
        </div>
        <?= form_close() ?>
    </div>
</div>
<div id="tampil_modal"></div>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
        data();
    });

    function data() {
        $('#data_tmp').html('<tr><td class="text-center text-red" colspan="8"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></td></tr>');
        $.ajax({
            url: "<?= site_url('permintaan/tmp-create/data') ?>",
            method: "GET",
            success: function(resp) {
                $('#data_tmp').html(resp);
            }
        });
    }

    function create() {
        $.ajax({
            url: "<?= site_url('permintaan/tmp-create/create') ?>",
            type: "GET",
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }

    function edit(kode) {
        $.ajax({
            url: "<?= site_url('permintaan/tmp-create/edit') ?>",
            type: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }

    $(document).on('change', '.barang', function(e) {
        var barang = $(".barang").val();
        $.ajax({
            type: "GET",
            url: "<?= site_url('barang/get-satuan') ?>",
            data: {
                barang: barang
            },
            success: function(resp) {
                $(".satuan").html(resp);
            }
        });
    });

    $(document).on('submit', '.form_tmp', function(e) {
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            cache: false,
            beforeSend: function() {
                $('.store_data').button('loading');
            },
            success: function(resp) {
                if (resp.status == "0100") {
                    $('#modal_create').modal('hide');
                    data();
                    toastr.success(resp.message);
                } else {
                    $.each(resp.pesan, function(key, value) {
                        var element = $('#' + key);
                        element.closest('div.form-group')
                            .removeClass('has-error')
                            .addClass(value.length > 0 ? 'has-error' : 'has-success')
                            .find('.help-block')
                            .remove();
                        element.after(value);
                    });
                    toastr.error(resp.message);
                }
            },
            complete: function() {
                $('.store_data').button('reset');
            }
        });
        return false;
    });
</script>