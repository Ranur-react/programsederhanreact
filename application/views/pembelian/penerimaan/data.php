<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <a href="<?= site_url('penerimaan/create') ?>" class="btn btn-social btn-flat btn-success btn-sm"><i class="icon-plus3"></i> Tambah <?= $title ?></a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped tabel_permintaan" style="width: 100%">
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
<script>
    $(".tabel_permintaan").DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('penerimaan/data') ?>",
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
                "class": "text-left"
            },
            {
                "class": "text-right"
            },
            {
                "class": "text-left"
            },
            {
                "class": "text-center",
                "width": "100px"
            },
            {
                "class": "text-center",
                "width": "60px"
            }
        ]
    });
</script>