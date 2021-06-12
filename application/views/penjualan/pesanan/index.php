<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <a href="<?= site_url('pesanan/create') ?>" class="btn btn-social btn-flat btn-success btn-sm"><i class="icon-plus3"></i> Tambah <?= $title ?></a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped data_pesanan">
                <thead>
                    <tr>
                        <th>No Invoice</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Metode Bayar</th>
                        <th class="text-right">Total</th>
                        <th>Konfirmasi</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div id="tampil-modal"></div>
<script>
    $(".data_pesanan").DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('pesanan/data') ?>",
            type: 'GET',
        },
        "columns": [{
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
            }
        ]
    });

    function detail(kode) {
        $.ajax({
            url: "<?= site_url('pesanan/detail') ?>",
            type: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $("#tampil-modal").html(resp);
                $("#modal_alert").modal('show');
            }
        });
    }

    function confirm(kode) {
        $.ajax({
            url: "<?= site_url('pembayaran/confirm') ?>",
            type: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $("#tampil-modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }
</script>