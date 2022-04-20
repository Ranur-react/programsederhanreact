@section(style)
<link rel="stylesheet" href="<?= assets() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection
@section(content)
<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <a href="<?= site_url('produk/create') ?>" class="btn btn-social btn-flat btn-success btn-sm"><i class="icon-plus3"></i> Tambah <?= $title ?></a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped data-tabel">
                <thead>
                    <tr>
                        <th class="text-center" width="40px">No.</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Referensi Pemasok</th>
                        <th>Stok</th>
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
<script src="<?= assets_js() ?>katalog/produk/index.js"></script>
@endsection