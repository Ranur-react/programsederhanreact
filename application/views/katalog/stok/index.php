<div class="col-xs-12">
    <div class="box box-widget">
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped tabel_stok">
                <thead>
                    <tr>
                        <th class="text-center" width="40px">No.</th>
                        <th>Barang</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    $(".tabel_stok").DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('stok-barang/data') ?>",
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