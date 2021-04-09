<div class="col-xs-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('penerimaan') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Tambah Penerimaan Barang
            </h3>
        </div>
        <?= form_open('penerimaan/store', ['id' => 'form_create']) ?>
        <input type="hidden" name="id_permintaan" id="id_permintaan">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <button type="button" onclick="data_permintaan()" class="btn btn-social btn-block btn-flat btn-primary btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i class="icon-folder-search"></i> Cari data permintaan barang</button>
                    <div id="show_permintaan"></div>
                </div>
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" width="40px">No</th>
                                    <th>Barang</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right">Jumlah</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-center" width="60px">#</th>
                                </tr>
                            </thead>
                            <tbody id="data_tmp"></tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Terima</label>
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tanggal" class="form-control pull-right datepicker" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y') ?>">
                                </div>
                                <div id="tanggal"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="gudang">Pilih Gudang</label>
                                <select class="form-control select2" name="gudang" data-placeholder="Pilih Gudang" style="width: 100%;">
                                    <option value=""></option>
                                    <?php foreach ($gudang as $g) { ?>
                                        <option value="<?= $g['id_gudang'] ?>"><?= $g['nama_gudang'] ?></option>
                                    <?php } ?>
                                </select>
                                <div id="gudang"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <a href="javascript:void(0)" class="btn btn-danger pull-right" onclick="batal()"><i class="icon-cross2"></i> Batalkan Penerimaan</a>
            <button type="submit" class="btn btn-primary pull-right" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..." style="margin-right: 5px;"><i class="icon-floppy-disk"></i> Simpan Penerimaan</button>
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
            url: "<?= site_url('penerimaan/tmp-create/data') ?>",
            method: "GET",
            success: function(resp) {
                $('#data_tmp').html(resp);
            }
        });
    }

    function data_permintaan() {
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-create/modal-permintaan') ?>",
            type: "GET",
            success: function(reps) {
                $("#tampil_modal").html(reps);
                $("#modal_data").modal('show');
            }
        });
    }

    function pilih(id_permintaan) {
        $("#id_permintaan").val(id_permintaan);
        $('#modal_data').modal('hide');
        show_permintaan();
    }

    function show_permintaan() {
        var id_permintaan = $('#id_permintaan').val();
        $('#show_permintaan').html('<p class="text-center m-t-0 m-b-2 text-red"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></p>');
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-create/show-permintaan') ?>",
            method: "GET",
            data: {
                id_permintaan: id_permintaan
            },
            success: function(resp) {
                $('#show_permintaan').html(resp);
            }
        });
    }

    function create(kode) {
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-create/create') ?>",
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

    function edit(kode) {
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-create/edit') ?>",
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

    function destroy(kode) {
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-create/destroy') ?>",
            type: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                data();
            }
        });
    }

    function batal() {
        Swal({
            title: "Anda yakin untuk membatalkan form penerimaan barang?",
            text: "Anda tidak akan dapat mengembalikan data ini!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Ya, batalkan proses ini"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "get",
                    url: "<?= site_url('penerimaan/tmp-create/batal') ?>",
                    dataType: "json",
                    success: function(resp) {
                        if (resp.status == "0100") {
                            Swal.fire({
                                title: 'Canceled!',
                                text: resp.message,
                                type: 'success'
                            }).then((resp) => {
                                location.reload();
                            })
                        } else {
                            Swal.fire('Oops...', resp.message, 'error');
                        }
                    }
                });
            }
        })
    }

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
                    if (resp.count == 0) {
                        $('#modal_create').modal('hide');
                        data();
                        toastr.success(resp.notif);
                    } else {
                        $('#message').html(resp.message);
                    }
                } else {
                    $('#message').html(resp.message);
                    $.each(resp.pesan, function(key, value) {
                        var element = $('#' + key);
                        element.closest('div.form-group')
                            .removeClass('has-error')
                            .addClass(value.length > 0 ? 'has-error' : 'has-success')
                            .find('.help-block')
                            .remove();
                        element.after(value);
                    });
                    toastr.error(resp.notif);
                }
            },
            complete: function() {
                $('.store_data').button('reset');
            }
        });
        return false;
    });

    $('#form_create').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: $("#form_create").attr('action'),
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#store').button('loading');
            },
            success: function(resp) {
                if (resp.status == "0100") {
                    if (resp.count == 0) {
                        var generate_html = '<div id="modal-alert" tabindex="-1" data-backdrop="static" class="modal_alert_new modal fade">' +
                            '<div class="modal-dialog">' +
                            '<div class="modal-content">' +
                            '<div class="modal-header text-white"><i class="fa fa-check-circle"></i> <b>Peringatan!</b></div>' +
                            '<div class="modal-body">' +
                            '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>' +
                            resp.message +
                            '</div>' +
                            '</div>' +
                            '<div class="modal-footer">' +
                            '<button type="button" data-dismiss="modal" class="btn btn-default btn-sm"> <i class="icon-cross2"></i> Tutup</button>' +
                            '</div>'
                        '</div>' +
                        '</div>' +
                        '</div>';
                        $("#tampil_modal").html(generate_html);
                        $("#modal-alert").modal('show');
                    } else {
                        Swal.fire({
                            title: 'Sukses!',
                            text: resp.message,
                            type: 'success'
                        }).then(okay => {
                            if (okay) {
                                window.location.href = "#";
                            }
                        });
                    }
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
                }
            },
            complete: function() {
                $('#store').button('reset');
            }
        })
    });
</script>