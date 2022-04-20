@section(style)
<link rel="stylesheet" href="<?= assets() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection
@section(content)
<div class="col-xs-12">
    <div class="box box-widget">
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped data-tabel">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th>Produk</th>
                        <th>Harga</th>
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
<script>
    $(document).ready(function() {
        table = $('.data-tabel').DataTable({
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": BASE_URL + "harga/data",
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
                    "class": "text-center"
                }
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData[2] == '0') {
                    $('td', nRow).css('background-color', '#f2dede');
                }
            }
        });
    });

    $(document).on('click', '.detail', function() {
        var id = $(this).attr('id');
        $.ajax({
            url: BASE_URL + 'harga/detail',
            type: 'GET',
            data: {
                id: id
            },
            success: function(resp) {
                $('#tampil_modal').html(resp);
                $('#modal_alert').modal('show');
            }
        });
    });
</script>
@endsection