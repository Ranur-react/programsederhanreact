$(document).ready(function() {
    load_data();
});

function load_data() {
    $.ajax({
        url: BASE_URL + 'rekening/data',
        method: "GET",
        dataType: 'json',
        success: function(data) {
            var html = '';
            var no = 1;
            if (data == 0) {
                html += '<tr>';
                html += '<td colspan="6">Belum ada data</td>';
                html += '</tr>';
            } else {
                for (var i = 0; i < data.length; i++) {
                    html += '<tr>';
                    html += '<td class="text-center">';
                    html += '<a href="javascript:void(0)" onclick="edit(' + data[i].id + ')" title="Edit"><i class="icon-pencil7 text-green"></i></a> <a href="javascript:void(0)" onclick="destroy(' + data[i].id + ')"><i class="icon-trash text-red" title="Hapus"></i></a>';
                    html += '</td>';
                    html += '<td>' + data[i].nama + '</td>';
                    html += '<td>' + data[i].kcb + '</td>';
                    html += '<td>' + data[i].norek + '</td>';
                    html += '<td>' + data[i].pemilik + '</td>';
                    html += '<td>' + data[i].status + '</td>';
                    html += '</tr>';
                    no++;
                }
            }
            $('#data').html(html);
        }
    })
}

function create() {
    $.ajax({
        url: BASE_URL + 'rekening/create',
        type: "GET",
        success: function(resp) {
            $("#tampil_modal").html(resp);
            $("#modal_create").modal('show');
        }
    });
}

function edit(kode) {
    $.ajax({
        url: BASE_URL + 'rekening/edit',
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
                url: BASE_URL + 'rekening/destroy',
                data: {
                    kode: kode
                },
                dataType: "json",
                success: function(resp) {
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
}

$(document).on('submit', '.form_create', function(e) {
    event.preventDefault();
    var formData = new FormData($(".form_create")[0]);
    $.ajax({
        url: $(".form_create").attr('action'),
        dataType: 'json',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('.store_data').button('loading');
        },
        success: function(resp) {
            resetToken(resp.token);
            if (resp.status == "0100") {
                Swal.fire('Sukses', resp.pesan, 'success', ).then((resp) => {
                    $("#modal_create").modal('hide');
                    load_data();
                });
            } else {
                $("#pesan_gambar").html(resp.error);
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
            $('.store_data').button('reset');
        }
    })
});