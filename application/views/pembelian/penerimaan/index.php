@section(style)
<link rel="stylesheet" href="<?= assets() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection
@section(content)
<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <a href="<?= site_url('penerimaan/create') ?>" class="btn btn-social btn-flat btn-success btn-sm"><i class="icon-plus3"></i> Tambah <?= $title ?></a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped data-tabel">
                <thead>
                    <tr>
                        <th class="text-center" width="40px">No.</th>
                        <th>No. Terima</th>
                        <th>Supplier</th>
                        <th>Gudang</th>
                        <th>Tanggal</th>
                        <th class="text-right">Total</th>
                        <th>User</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
@endsection
@section(script)
<script src="<?= assets() ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= assets() ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?= assets() ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        table = $('.data-tabel').DataTable({
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": BASE_URL + "penerimaan/data",
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
                    "class": "text-right"
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

    $(document).on('click', '.detail', function() {
        var id = $(this).attr('id');
        $.ajax({
            url: BASE_URL + 'penerimaan/view',
            type: 'GET',
            data: {
                id: id
            },
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_alert").modal('show');
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
                    url: BASE_URL + 'penerimaan/destroy',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(resp) {
                        if (resp.status == '0100') {
                            Swal.fire('Dihapus!', resp.msg, 'success').then((resp) => {
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
    });
</script>
@endsection