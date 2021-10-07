$(document).ready(function () {
    load_data();
});

function load_data() {
    $.ajax({
        url: BASE_URL + 'konversi-satuan/data',
        method: "GET",
        dataType: 'json',
        success: function (data) {
            var html = '';
            if (data == 0) {
                html += '<tr>';
                html += '<td colspan="4">Belum ada data</td>';
                html += '</tr>';
            } else {
                for (var i = 0; i < data.length; i++) {
                    html += '<tr>';
                    html += '<td class="text-center">';
                    html += '<a href="javascript:void(0)" class="edit" id="' + data[i].id + '" title="Edit"><i class="icon-pencil7 text-green"></i></a> <a href="javascript:void(0)" class="destroy" id="' + data[i].id + '"><i class="icon-trash text-red" title="Hapus"></i></a>';
                    html += '</td>';
                    html += '<td>Dari <strong>' + data[i].satuan_terbesar + '</strong> ke <strong>' + data[i].satuan_terkecil + '</strong></td>';
                    html += '<td>' + data[i].nilai + '</td>';
                    html += '</tr>';
                }
            }
            $('#data').html(html);
        }
    })
}

$(document).on('click', '.create', function (e) {
    $.ajax({
        url: BASE_URL + 'konversi-satuan/create',
        type: "GET",
        success: function (resp) {
            $("#tampil_modal").html(resp);
            $("#modal_create").modal('show');
        }
    });
});

$(document).on('click', '.edit', function (e) {
    var id = $(this).attr('id');
    $.ajax({
        url: BASE_URL + 'konversi-satuan/edit',
        type: "GET",
        data: {
            id: id
        },
        success: function (resp) {
            $("#tampil_modal").html(resp);
            $("#modal_create").modal('show');
        }
    });
});
$(document).on('click', '.destroy', function (e) {
    var id = $(this).attr('id');
    Swal.fire({
        title: "Apakah kamu yakin?",
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Ya, hapus data ini"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "get",
                url: BASE_URL + 'konversi-satuan/destroy',
                data: {
                    id: id
                },
                dataType: "json",
                success: function (resp) {
                    if (resp.status == "0100") {
                        Swal.fire('Deleted!', resp.msg, 'success').then((resp) => {
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

$(document).on('submit', '.form_create', function (e) {
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
                Swal.fire('Sukses', resp.pesan, 'success',).then((resp) => {
                    $("#modal_create").modal('hide');
                    load_data();
                });
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
            $('.store_data').button('reset');
        }
    });
    return false;
});