@section(style)
<link rel="stylesheet" href="<?= assets() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection
@section(content)
<div class="col-xs-12">
    <div class="box box-widget">
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped data-pelanggan">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Ponsel</th>
                        <th>Tgl Daftar</th>
                        <th class="text-center">Status</th>
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
<script src="<?= assets_js() ?>master/pelanggan.js"></script>
@endsection