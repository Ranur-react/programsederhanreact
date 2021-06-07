<div class="col-xs-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('penerimaan') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Edit Penerimaan Barang
            </h3>
            <h3 class="box-title pull-right">Status Bayar : <?= status_label($data['status_terima'], 'penerimaan') ?></h3>
        </div>
        <?= form_open('penerimaan/update', ['id' => 'form_create']) ?>
        <input type="hidden" name="kode" id="kode" value="<?= $data['id_terima'] ?>">
        <input type="hidden" name="id_minta" id="id_minta">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <button type="button" onclick="data_permintaan()" class="btn btn-social btn-block btn-flat btn-primary btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i class="icon-folder-search"></i>Cari data permintaan barang</button>
                    <div id="show_permintaan"></div>
                    <div id="data_supplier"></div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default m-y-1">
                        <div class="panel-body panel-body-custom">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12 ">
                                    <div class="row">
                                        <div class="col-md-2"><b>Nomor</b> <span class="value">:</span></div>
                                        <div class="col-md-10"><?= $data['nosurat_terima'] ?></div>
                                        <div class="col-md-2"><b>Tanggal Terima</b> <span class="value">:</span></div>
                                        <div class="col-md-10"> <?= format_indo($data['tanggal_terima']) ?></div>
                                        <div class="col-md-2"><b>Supplier</b> <span class="value">:</span></div>
                                        <div class="col-md-10"><?= $data['nama_supplier'] ?></div>
                                        <div class="col-md-2"><b>Gudang</b> <span class="value">:</span></div>
                                        <div class="col-md-10"><?= $data['nama_gudang'] ?></div>
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
                                    <input type="text" name="tanggal" class="form-control pull-right datepicker" placeholder="dd-mm-yyyy" value="<?= format_biasa($data['tanggal_terima']) ?>">
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
                                        <option value="<?= $g['id_gudang'] ?>" <?= $data['gudang_terima'] == $g['id_gudang'] ? 'selected' : null ?>><?= $g['nama_gudang'] ?></option>
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
            <button type="submit" class="btn btn-primary" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..."><i class="icon-floppy-disk"></i> Edit Penerimaan</button>
            <a href="javascript:void(0)" class="btn btn-danger"><i class="icon-cross2"></i> Batalkan Penerimaan</a>
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
        data_supplier();
        data_tmp();
    });

    var kode = $('#kode').val();

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

    function pilih(id_minta) {
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-edit/check-permintaan') ?>",
            type: "GET",
            dataType: "json",
            data: {
                id_terima: kode,
                id_minta: id_minta
            },
            success: function(resp) {
                if (resp.status == "0100") {
                    $("#id_minta").val(id_minta);
                    $('#modal_data').modal('hide');
                    show_permintaan();
                } else {
                    toastr.error(resp.pesan);
                }
            }
        });
    }

    function show_permintaan() {
        var id_minta = $('#id_minta').val();
        $('#show_permintaan').html('<p class="text-center m-t-0 m-b-2 text-red"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></p>');
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-create/show-permintaan') ?>",
            method: "GET",
            data: {
                id_permintaan: id_minta
            },
            success: function(resp) {
                $('#show_permintaan').html(resp);
            }
        });
    }

    function data_supplier() {
        $('#data_supplier').html('<p class="text-center m-y-1 text-red"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></p>');
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-edit/data-supplier') ?>",
            method: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $('#data_supplier').html(resp);
            }
        });
    }

    function data_tmp() {
        $('#data_tmp').html('<tr><td class="text-center text-red" colspan="8"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></td></tr>');
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-edit/data-tmp') ?>",
            method: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $('#data_tmp').html(resp);
            }
        });
    }

    function create(id_detail) {
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-edit/create') ?>",
            type: "GET",
            data: {
                id_detail: id_detail,
                id_terima: kode
            },
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }

    function edit(kode) {
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-edit/edit') ?>",
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
            url: "<?= site_url('penerimaan/tmp-edit/destroy') ?>",
            type: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $('#id_minta').val('');
                show_permintaan();
                data_supplier();
                data_tmp();
            }
        });
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
                    $('#modal_create').modal('hide');
                    $('#id_minta').val('');
                    show_permintaan();
                    data_supplier();
                    data_tmp();
                    if (resp.count > 0) {
                        toastr.error(resp.message);
                    } else {
                        toastr.success(resp.message);
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
                    toastr.error(resp.message);
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
                            '<button type="button" data-dismiss="modal" class="btn btn-danger btn-sm"> <i class="icon-cross2"></i> Tutup</button>' +
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
                                window.location.href = "<?= site_url('penerimaan/detail/') ?>" + resp.kode;
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