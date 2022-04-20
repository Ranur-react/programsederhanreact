$(document).ready(function () {
    $('.select2').select2();
    $('.datepicker').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true
    });
    data_tmp();
});

var kode = $('input[name=\'kode\']').val();

function data_tmp() {
    $('#data_tmp').html('<tr><td class="text-center text-red" colspan="8"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></td></tr>');
    $.ajax({
        url: BASE_URL + 'permintaan/tmp-edit/data',
        method: "GET",
        dataType: 'json',
        data: {
            kode: kode
        },
        success: function (resp) {
            var html = '';
            if (resp["dataProduk"] == 0) {
                html += '<tr>';
                html += '<td colspan="8" class="text-center text-red">Belum ada data produk yang diinputkan.</td>';
                html += '</tr>';
            } else {
                var no = 1;
                for (var count = 0; count < resp["dataProduk"].length; count++) {
                    html += '<tr>';
                    html += '<td class="text-center">' + no + '</td>';
                    html += '<td>' + resp["dataProduk"][count]["produk"] + '</td>';
                    html += '<td class="text-right">' + resp["dataProduk"][count]["hargaText"] + '</td>';
                    html += '<td class="text-right">' + resp["dataProduk"][count]["jumlahText"] + ' ' + resp["dataProduk"][count]["singkatan"] + '</td>';
                    html += '<td class="text-right">' + resp["dataProduk"][count]["totalText"] + '</td>';
                    html += '<td class="text-center">';
                    html += '<a href="javascript:void(0)" onclick="edit(' + resp["dataProduk"][count]["iddetail"] + ')"><i class="icon-pencil7 text-green"></i></a>';
                    html += '&nbsp;';
                    html += '<a href="javascript:void(0)" onclick="destroy(' + resp["dataProduk"][count]["iddetail"] + ')"><i class="icon-trash text-red"></i></a>';
                    html += '</td>';
                    html += '</tr>';
                    no++;
                }
                html += '<tr>';
                html += '<th colspan="4" class="text-right">Total</th>';
                html += '<th class="text-right">' + resp["totalText"] + '</th>';
                html += '</tr>';
            }
            $('#data_tmp').html(html);
        }
    });
}

function create() {
    $.ajax({
        url: BASE_URL + 'permintaan/tmp-edit/create',
        type: "GET",
        data: {
            kode: kode
        },
        success: function (resp) {
            $("#tampil_modal").html(resp);
            $("#modal_create").modal('show');
        }
    });
}

function edit(kode) {
    $.ajax({
        url: BASE_URL + 'permintaan/tmp-edit/edit',
        type: "GET",
        data: {
            kode: kode
        },
        success: function (resp) {
            $("#tampil_modal").html(resp);
            $("#modal_create").modal('show');
        }
    });
}

function destroy(kode) {
    Swal.fire({
        title: 'Anda yakin hapus data ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "OK"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + 'permintaan/tmp-edit/destroy',
                type: "GET",
                dataType: 'json',
                data: {
                    kode: kode
                },
                success: function (resp) {
                    if (resp.status == "0100") {
                        data_tmp();
                        toastr.success(resp.msg);
                    } else {
                        toastr.error(resp.msg);
                    }
                }
            });
        }
    })
}

function batal() {
    Swal.fire({
        title: "Anda yakin untuk membatalkan form permintaan produk?",
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
                url: BASE_URL + 'permintaan/tmp-edit/batal',
                dataType: "json",
                data: {
                    kode: kode
                },
                success: function (resp) {
                    if (resp.status == "0100") {
                        Swal.fire('Canceled!', resp.msg, 'success').then((resp) => {
                            window.location.href = BASE_URL + 'permintaan';
                        });
                    } else {
                        Swal.fire('Oops...', resp.msg, 'error');
                    }
                }
            });
        }
    })
}

$(document).on('change', '.idproduk', function (e) {
    var idproduk = $(".idproduk").val();
    $.ajax({
        type: "GET",
        url: BASE_URL + 'produk/get-satuan',
        data: {
            idproduk: idproduk
        },
        success: function (resp) {
            $(".satuan").html(resp);
        }
    });
});

$(document).on('submit', '.form_tmp', function (e) {
    $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        cache: false,
        beforeSend: function () {
            $('.store_data').button('loading');
        },
        success: function (resp) {
            resetToken(resp.token);
            if (resp.status == "0100") {
                $('#modal_create').modal('hide');
                data_tmp();
                toastr.success(resp.msg);
            } else {
                $.each(resp.pesan, function (key, value) {
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
        complete: function () {
            $('.store_data').button('reset');
        }
    });
    return false;
});

$('#form_create').on('submit', function (event) {
    event.preventDefault();
    $.ajax({
        url: $("#form_create").attr('action'),
        method: "POST",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function () {
            $('#store').button('loading');
        },
        success: function (resp) {
            resetToken(resp.token);
            if (resp.status == "0100") {
                if (resp.count == 0) {
                    Swal.fire('Gagal!', resp.msg, 'error');
                } else {
                    Swal.fire({
                        title: 'Sukses!',
                        text: resp.msg,
                        icon: 'success'
                    }).then(okay => {
                        if (okay) {
                            window.location.href = BASE_URL + 'permintaan/detail/' + resp.kode;
                        }
                    });
                }
            } else {
                $.each(resp.pesan, function (key, value) {
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
        complete: function () {
            $('#store').button('reset');
        }
    })
});