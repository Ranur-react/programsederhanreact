<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('permintaan') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Tambah Pesanan
            </h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" width="40px">No</th>
                            <th>Barang</th>
                            <th>Penerimaan</th>
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
                <div class="col-lg-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Pilih Customer</label>
                        <select class="form-control select2 customer" name="customer" data-placeholder="Pilih Customer">
                            <option value=""></option>
                            <?php foreach ($customer as $c) { ?>
                                <option value="<?= $c['id'] ?>"><?= $c['nama'] ?></option>
                            <?php } ?>
                        </select>
                        <div id="customer"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Pilih Alamat</label>
                        <select class="form-control select2" name="alamat" id="alamat" data-placeholder="Pilih Alamat">
                            <option value=""></option>
                        </select>
                        <div id="idalamat"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
<script>
    $(document).ready(function() {
        data_tmp();
    });

    function data_tmp() {
        $('#data_tmp').html('<tr><td class="text-center text-red" colspan="8"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></td></tr>');
        $.ajax({
            url: "<?= site_url('pesanan/tmp-create') ?>",
            method: "GET",
            success: function(resp) {
                $('#data_tmp').html(resp);
            }
        });
    }

    function create() {
        $.ajax({
            url: "<?= site_url('pesanan/tmp-create/create') ?>",
            type: "GET",
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }

    $(document).on('change', '.idbarang', function(e) {
        var idbarang = $(".idbarang").val();
        $.ajax({
            type: "GET",
            url: "<?= site_url('pesanan/tmp-create/get-penerimaan') ?>",
            data: {
                idbarang: idbarang
            },
            success: function(resp) {
                $("#list-penerimaan").html(resp);
            }
        });
    });

    $(document).on('change', '.idharga', function(e) {
        var idharga = $(".idharga").val();
        $.ajax({
            type: "GET",
            url: "<?= site_url('pesanan/tmp-create/get-harga') ?>",
            data: {
                idharga: idharga
            },
            success: function(resp) {
                $("#harga").html(resp);
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
                    data_tmp();
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