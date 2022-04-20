$(document).ready(function () {
    table = $('.data-tabel').DataTable({
        "ordering": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": BASE_URL + "produk/data",
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
                url: BASE_URL + 'produk/destroy',
                dataType: "json",
                data: {
                    kode: kode
                },
                success: function (resp) {
                    if (resp.status == "0100") {
                        Swal.fire('Deleted!', resp.msg, 'success').then((resp) => {
                            var DataTabel = $('.data-tabel').DataTable();
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