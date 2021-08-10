@section(style)
<link rel="stylesheet" href="<?= assets() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?= assets() ?>plugins/bootstrap-fileinput/fileinput.min.css">
@endsection
@section(content)
<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <button class="btn btn-social btn-flat btn-success btn-sm" onclick="create()"><i class="icon-plus3"></i> Tambah <?= $title ?></button>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped data_kategori">
                <thead>
                    <tr>
                        <th class="text-center" width="40px">No.</th>
                        <th>Kategori</th>
                        <th class="text-center">Image</th>
                        <th class="text-center" width="60px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
@endsection
@section(script)
<script src="<?= assets() ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= assets() ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?= assets() ?>plugins/bootstrap-fileinput/fileinput.min.js"></script>
<script src="<?= assets() ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= assets_js() ?>common.js"></script>
<script>
    $(".data_kategori").DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: BASE_URL + "kategori/data",
            type: 'GET',
        },
        "columns": [{
                "class": "text-center"
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

    function create() {
        $.ajax({
            url: BASE_URL + 'kategori/create',
            type: "GET",
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }

    function edit(kode) {
        $.ajax({
            url: BASE_URL + 'kategori/edit',
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
                    url: BASE_URL + 'kategori/destroy',
                    dataType: "json",
                    data: {
                        kode: kode
                    },
                    success: function(resp) {
                        if (resp.status == "0100") {
                            Swal.fire('Deleted!', resp.msg, 'success').then((resp) => {
                                var DataTabel = $('.data_kategori').DataTable();
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
                    Swal.fire('Sukses', resp.msg, 'success', ).then((resp) => {
                        $("#modal_create").modal('hide');
                        var DataTabel = $('.data_kategori').DataTable();
                        DataTabel.ajax.reload();
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
</script>
@endsection