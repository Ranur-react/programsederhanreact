@section(style)
<link rel="stylesheet" href="<?= assets() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection
@section(content)
<div class="col-xs-12">
    <div class="box box-widget">
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped tabel_stok">
                <thead>
                    <tr>
                        <th class="text-center" width="40px">No.</th>
                        <th>Produk</th>
                        <th>Satuan</th>
                        <th>Stok Keseluruhan</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@section(script)
<script src="<?= assets() ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= assets() ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(".tabel_stok").DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('stok-produk/data') ?>",
            type: 'GET',
        },
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
            }
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (aData[3] == '0') {
                $('td', nRow).css('background-color', '#f2dede');
            }
        }
    });
</script>
@endsection