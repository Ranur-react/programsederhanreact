@section(style)
<link rel="stylesheet" href="<?= assets() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?= assets() ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?= assets() ?>plugins/toastr/toastr.min.css">
@endsection
@section(content)
<div class="col-xs-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('penerimaan') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Tambah Penerimaan Produk
            </h3>
            <h3 class="box-title pull-right">No: <?= $nomor['nosurat']; ?></h3>
        </div>
        <?= form_open('penerimaan/store', ['id' => 'form_create']) ?>
        <input type="hidden" name="idminta" id="idminta">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-social btn-block btn-flat btn-primary btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block getPermintaan"><i class="icon-folder-search"></i> Cari data permintaan produk</button>
                    <div id="show_request"></div>
                </div>
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" width="40px">No</th>
                                    <th>Nama Produk</th>
                                    <th class="text-right">Jumlah</th>
                                    <th class="text-right">Harga Produk</th>
                                    <th class="text-right">Subtotal</th>
                                    <th class="text-center" width="60px">#</th>
                                </tr>
                            </thead>
                            <tbody id="data_tmp"></tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Terima</label>
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tanggal" class="form-control pull-right datepicker" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y') ?>">
                                </div>
                                <div id="tanggal"></div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="pemasok">Pilih Pemasok</label>
                                <select class="form-control select2" name="pemasok" data-placeholder="Pilih Pemasok" style="width: 100%;">
                                    <option value=""></option>
                                    <?php foreach ($supplier as $s) { ?>
                                        <option value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                                    <?php } ?>
                                </select>
                                <div id="pemasok"></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-md-6">
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
            <button type="button" class="btn btn-danger pull-right cancel"><i class="icon-cross2"></i> Batalkan Penerimaan</button>
            <button type="submit" class="btn btn-primary pull-right" id="store" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading..." style="margin-right: 5px;"><i class="icon-floppy-disk"></i> Simpan Penerimaan</button>
        </div>
        <?= form_close() ?>
    </div>
</div>
<div id="tampil_modal"></div>
@endsection
@section(script)
<script src="<?= assets() ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= assets() ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?= assets() ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= assets() ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= assets() ?>plugins/toastr/toastr.min.js"></script>
<script src="<?= assets_js() ?>common.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
        data_tmp();
    });

    function data_tmp() {
        $('#data_tmp').html('<tr><td class="text-center text-red" colspan="8"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></td></tr>');
        $.ajax({
            url: BASE_URL + 'penerimaan/tmp-create/data',
            method: "GET",
            dataType: "json",
            success: function(resp) {
                var html = '';
                if (resp['status'] == false) {
                    html += '<tr>';
                    html += '<td colspan="6" class="text-center text-red">Belum ada data produk yang diinputkan.</td>';
                    html += '</tr>';
                } else {
                    var no = 1;
                    var total = 0;
                    for (var i = 0; i < resp['data'].length; i++) {
                        html += '<tr>';
                        html += '<td class="text-center">' + no + '</td>';
                        html += '<td>' + resp['data'][i]['produk'] + '</td>';
                        html += '<td class="text-right">' + resp['data'][i]['jumlah'] + '</td>';
                        html += '<td class="text-right">' + resp['data'][i]['harga'] + '</td>';
                        html += '<td class="text-right">' + resp['data'][i]['subtotal'] + '</td>';
                        html += '<td class="text-center">';
                        html += '<a href="javascript:void(0)" class="edit" id="' + resp['data'][i]['id'] + '"><i class="icon-pencil7 text-green"></i></a>';
                        html += '&nbsp;';
                        html += '<a href="javascript:void(0)" class="destroy" id="' + resp['data'][i]['id'] + '"><i class="icon-trash text-red"></i></a>';
                        html += '</td>';
                        html += '</tr>';
                        no++;
                    }
                    html += '<tr>';
                    html += '<th colspan="4" class="text-right">Total</th>';
                    html += '<th class="text-right">' + resp['total'] + '</th>';
                    html += '</tr>';
                }
                $('#data_tmp').html(html);
            }
        });
    }

    $(document).on('click', '.getPermintaan', function(e) {
        $.ajax({
            url: BASE_URL + 'penerimaan/tmp-permintaan',
            type: "GET",
            success: function(reps) {
                $("#tampil_modal").html(reps);
                $("#modal-data").modal('show');
            }
        });
    });

    $(document).on('click', '.pilih-request', function() {
        var idminta = $(this).attr('id');
        $.ajax({
            url: BASE_URL + 'penerimaan/tmp-permintaan/show',
            type: "GET",
            dataType: "json",
            data: {
                idminta: idminta
            },
            success: function(resp) {
                if (resp.status == "0100") {
                    $("#idminta").val(resp["data"]["id"]);
                    html = '<div class="panel panel-default m-t-1 m-b-0">';
                    html += '<div class="panel-body panel-body-custom">';
                    html += '<div class="row">';
                    html += '<di class="col-lg-12 col-xs-12 ">';
                    html += '<div class="row">';
                    html += '<div class="col-lg-2 col-xs-4"><b>Nomor</b><span class="value">:</span></div>';
                    html += '<div class="col-lg-10 col-xs-8">' + resp["data"]["nomor"] + '</div>';
                    html += '<div class="col-lg-2 col-xs-4"><b>Tanggal</b><span class="value">:</span></div>';
                    html += '<div class="col-lg-10 col-xs-8">' + resp["data"]["tanggal_format"] + '</div>';
                    html += '<div class="col-lg-2 col-xs-4"><b>Status</b><span class="value">:</span></div>';
                    html += '<div class="col-lg-10 col-xs-8">' + resp["data"]["status_label"] + '</div>';
                    html += '<div class="col-lg-2 col-xs-4"><b>User</b> <span class="value">:</span></div>';
                    html += '<div class="col-lg-10 col-xs-8">' + resp["data"]["user"] + '</div>';
                    html += '</div></di></div></div></div>';
                    html += '<div class="table-responsive">';
                    html += '<div class="data-item line"></div>';
                    html += '<h5 class="data-item title">Daftar Produk</h5>';
                    html += '<table class="table-responsive data-list">';
                    html += '<tbody><tr class="row-list-border">';
                    html += '<td class="list-p-1" width="230">Nama Produk</td>';
                    html += '<td class="list-p-1 text-center">Jumlah</td>';
                    html += '<td class="list-p-1 text-right">Harga Produk</td>';
                    html += '<td class="list-p-1 text-right">Subtotal</td>';
                    html += '<td class="list-p-1 text-center">#</td>';
                    html += '</tr>';
                    for (var i = 0; i < resp["data"]["dataProduk"].length; i++) {
                        html += '<tr class="row-list-item">';
                        html += '<td class="list-p-2 row-list-title">' + resp["data"]["dataProduk"][i]["produk"] + '</td>';
                        // html += '<td class="list-p-2 row-list-title">Produk<div class="row-list-desc">100 gram</div></td>';
                        html += '<td class="list-p-2 text-center" valign="top">' + resp["data"]["dataProduk"][i]["jumlahProduk"] + '</td>';
                        html += '<td class="list-p-2 text-right" valign="top">' + resp["data"]["dataProduk"][i]["hargaText"] + '</td>';
                        html += '<td class="list-p-2 text-right" valign="top">' + resp["data"]["dataProduk"][i]["totalText"] + '</td>';
                        html += '<td class="list-p-2 text-center" valign="top">';
                        if (resp["data"]["dataProduk"][i]["statusTerima"] > 0) {
                            html += '<i class="icon-checkmark-circle2 text-blue"></i>';
                        } else {
                            html += '<a class="btn btn-success btn-xs create" id="' + resp["data"]["dataProduk"][i]["iddetail"] + '"><i class="fa fa-plus-circle"></i> Tambah</a>';
                        }
                        html += '</td>';
                        html += '</tr>';
                    }
                    html += '<tr><td colspan="4" style="padding: 0 10px;"><div class="row-list-line"></div></td></tr>';
                    html += '<tr><td colspan="2"></td><td colspan="2" style="padding-right: 10px;"><table class="footer"><tbody><tr><td colspan="2"><div class="row-list-line"></div></td></tr><tr>';
                    html += '<td class="list-p-2 text-right">Total Harga Produk</td>';
                    html += '<td class="footer-distance text-right">' + resp["data"]["totalText"] + '</td>';
                    html += '</tr></tbody></table></td></tr></tbody></table></div>';
                    $('#show_request').html(html);
                    $('#modal-data').modal('hide');
                    toastr.success(resp.msg);
                } else {
                    toastr.error(resp.msg);
                }
            }
        });
    });

    $(document).on('click', '.create', function() {
        var iddetail = $(this).attr('id');
        $.ajax({
            url: BASE_URL + 'penerimaan/tmp-create/create',
            type: "GET",
            data: {
                iddetail: iddetail
            },
            success: function(resp) {
                if ((resp == '0101')) {
                    toastr.error('Produk sudah ditambahkan, silahkan update jika ingin melakukan perubahan.');
                } else if ((resp == '0102')) {
                    toastr.error('Produk sudah ditambahkan oleh user yang lain.');
                } else {
                    $("#tampil_modal").html(resp);
                    $("#modal_create").modal('show');
                }
            }
        });
    });

    $(document).on('click', '.edit', function() {
        var id = $(this).attr('id');
        $.ajax({
            url: BASE_URL + 'penerimaan/tmp-create/edit',
            type: "GET",
            data: {
                id: id
            },
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    });

    $(document).on('click', '.destroy', function() {
        var id = $(this).attr('id');
        $.ajax({
            url: BASE_URL + 'penerimaan/tmp-create/destroy',
            type: "GET",
            data: {
                id: id
            },
            success: function(resp) {
                data_tmp();
            }
        });
    });

    $(document).on('click', '.cancel', function() {
        Swal.fire({
            title: "Apa kamu yakin?",
            text: "Anda tidak akan dapat mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Ya, batalkan proses ini"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: BASE_URL + 'penerimaan/tmp-create/batal',
                    dataType: "json",
                    success: function(resp) {
                        if (resp.status == "0100") {
                            Swal.fire('Canceled!', resp.msg, 'success').then((resp) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Oops...', resp.msg, 'error');
                        }
                    }
                });
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
                resetToken(resp.token);
                if (resp.status == "0100") {
                    data_tmp();
                    $('#modal_create').modal('hide');
                    toastr.success(resp.msg);
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
                    toastr.error(resp.msg);
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
                resetToken(resp.token);
                if (resp.status == '0100') {
                    if (resp.count == 0) {
                        Swal.fire('Oops...', resp.msg, 'info');
                    } else {
                        Swal.fire({
                            title: 'Sukses!',
                            text: resp.msg,
                            icon: 'success'
                        }).then(okay => {
                            if (okay) {
                                window.location.href = BASE_URL + 'penerimaan/detail/' + resp.kode;
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
@endsection