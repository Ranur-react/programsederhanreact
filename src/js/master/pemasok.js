$(document).ready(function() {
    table = $('.data-pemasok').DataTable({
        "ordering": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": BASE_URL + "pemasok/data",
            "type": "GET"
        },
        "columnDefs": [{
            "targets": [0],
            "orderable": false,
        }],
        "columns": [{
                "class": "text-center"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-center"
            },
            {
                "class": "text-center"
            }
        ]
    });
});

function create() {
    $.ajax({
        url: BASE_URL + "pemasok/create",
        type: "GET",
        success: function(resp) {
            $("#tampil_modal").html(resp);
            $("#modal_create").modal('show');
        }
    });
}

function edit(kode) {
    $.ajax({
        url: BASE_URL + "pemasok/edit",
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
                url: BASE_URL + 'pemasok/destroy',
                dataType: "json",
                data: {
                    kode: kode
                },
                success: function(resp) {
                    if (resp.status == "0100") {
                        Swal.fire('Deleted!', resp.msg, 'success').then((resp) => {
                            var DataTabel = $('.data-pemasok').DataTable();
                            DataTabel.ajax.reload();
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
                Swal.fire('Sukses', resp.pesan, 'success', ).then((resp) => {
                    $("#modal_create").modal('hide');
                    var DataTabel = $('.data-pemasok').DataTable();
                    DataTabel.ajax.reload();
                });
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
            $('.store_data').button('reset');
        }
    });
    return false;
});