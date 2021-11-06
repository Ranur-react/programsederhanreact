<?php if ($data['status'] == false) : ?>
    @section(content)
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-widget">
            <div class="box-header with-border">
                <h3 class="box-title"><a href="<?= site_url('penerimaan') ?>" class="text-back" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Kembali ke daftar penerimaan</h3>
            </div>
            <div class="box-body">
                <div class="css-nodata">
                    <h1 data-unify="Typography" class="css-nodata-title">Data tidak ditemukan!</h1>
                    <p data-unify="Typography" class="css-nodata-desc">Coba ulangi pencarian anda atau masukkan kata kunci baru</p>
                </div>
            </div>
        </div>
    </div>
    @endsection
<?php else : ?>
    @section(style)
    <link rel="stylesheet" href="<?= assets() ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?= assets() ?>plugins/toastr/toastr.min.css">
    @endsection
    @section(content)
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><a href="<?= site_url('penerimaan') ?>" class="text-back" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Rincian Pelunasan Penerimaan</h3>
                </div>
                <div class="box-body">
                    <input type="hidden" id="idterima" name="idterima" value="<?= $data['idterima']; ?>">
                    <div class="panel panel-default m-y-1">
                        <div class="panel-body panel-body-custom">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12 ">
                                    <div class="row">
                                        <div class="col-md-2"><b>Nomor</b><span class="value">:</span></div>
                                        <div class="col-md-4"><?= $data['nomor'] ?></div>
                                        <div class="col-md-2"><b>Total Tagihan</b><span class="value">:</span></div>
                                        <div class="col-md-4"><?= $data['totalText'] ?></div>
                                        <div class="col-md-2"><b>Tanggal Terima</b><span class="value">:</span></div>
                                        <div class="col-md-4"><?= $data['tanggalText'] ?></div>
                                        <div class="col-md-2"><b>Pembayaran</b><span class="value">:</span></div>
                                        <div class="col-md-4"><span id="pembayaran"></span></div>
                                        <div class="col-md-2"><b>Pemasok</b><span class="value">:</span></div>
                                        <div class="col-md-4"><?= $data['pemasok'] ?></div>
                                        <div class="col-md-2"><b>Sisa Pembayaran</b><span class="value">:</span></div>
                                        <div class="col-md-4"><span id="sisa-bayar"></span></div>
                                        <div class="col-md-2"><b>Status</b><span class="value">:</span></div>
                                        <div class="col-md-10"><span id="status-bayar"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="data-item title" style="margin-top: 0; font-weight: 600">Histori Pelunasan Penerimaan</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" width="40px">No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th class="text-right">Jumlah</th>
                                <th class="text-center" width="60px">
                                    <a href="javascript:void(0)" class="create"><i class="icon-plus-circle2 text-blue" title="Tambah"></i></a>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="data-bayar"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="tampil_modal"></div>
    @endsection
    @section(script)
    <script src="<?= assets() ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= assets() ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?= assets() ?>plugins/toastr/toastr.min.js"></script>
    <script src="<?= assets_js() ?>common.js"></script>
    <script>
        var idterima = $('input[name=\'idterima\']').val();

        $(document).ready(function() {
            load_data();
        });

        function load_data() {
            $('#data-bayar').html('<tr><td class="text-center text-red" colspan="5"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></td></tr>');
            $.ajax({
                url: BASE_URL + 'penerimaan/pelunasan/data',
                method: 'GET',
                dataType: 'json',
                data: {
                    idterima: idterima
                },
                success: function(resp) {
                    var html = '';
                    $('#pembayaran').html(resp["totalBayarText"]);
                    $('#sisa-bayar').html(resp["sisaBayarText"]);
                    $('#status-bayar').html(resp["statusText"]);
                    if (resp['dataBayar'].length > 0) {
                        var no = 1;
                        for (var i = 0; i < resp['dataBayar'].length; i++) {
                            html += '<tr>';
                            html += '<td class="text-center">' + no + '</td>';
                            html += '<td>' + resp['dataBayar'][i]['tanggalText'] + '</td>';
                            html += '<td>' + resp['dataBayar'][i]['note'] + '</td>';
                            html += '<td class="text-right">' + resp['dataBayar'][i]['jumlahText'] + '</td>';
                            html += '<td class="text-center">';
                            html += '<a href="javascript:void(0)" class="destroy" id="' + resp['dataBayar'][i]['idbayar'] + '"><i class="icon-trash text-red"></i></a>';
                            html += '</td>';
                            html += '</tr>';
                            no++;
                        }
                        html += '<tr>';
                        html += '<th colspan="3" class="text-right">Total</th>';
                        html += '<th class="text-right">' + resp['totalBayarText'] + '</th>';
                        html += '</tr>';
                    } else {
                        html += '<tr>';
                        html += '<td colspan="5" class="text-center text-red">Belum ada data pelunasan yang diinputkan.</td>';
                        html += '</tr>';
                    }
                    $('#data-bayar').html(html);
                }
            });
        }

        $(document).on('click', '.create', function() {
            $.ajax({
                url: BASE_URL + 'penerimaan/pelunasan/create',
                type: 'GET',
                data: {
                    idterima: idterima
                },
                success: function(resp) {
                    $("#tampil_modal").html(resp);
                    $("#modal_create").modal('show');
                }
            });
        });

        $(document).on('click', '.destroy', function() {
            var id = $(this).attr('id');
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: 'Anda tidak dapat mengembalikan data ini!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BASE_URL + 'penerimaan/pelunasan/destroy',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function(resp) {
                            if (resp.status == '0100') {
                                Swal.fire('Dihapus!', resp.msg, 'success').then((resp) => {
                                    load_data();
                                });
                            } else {
                                Swal.fire('Oops...', resp.msg, 'error');
                            }
                        }
                    });
                }
            })
        });

        $(document).on('submit', '.form_create', function(e) {
            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                cache: false,
                beforeSend: function() {
                    $('.store_data').button('loading');
                },
                success: function(resp) {
                    resetToken(resp.token);
                    if (resp.status == '0100') {
                        load_data();
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
    </script>
    @endsection
<?php endif; ?>