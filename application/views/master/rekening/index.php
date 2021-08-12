@section(style)
<link rel="stylesheet" href="<?= assets() ?>plugins/bootstrap-fileinput/fileinput.min.css">
@endsection
@section(content)
<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <button class="btn btn-social btn-flat btn-success btn-sm" title="Tambah Data" onclick="create()"><i class="icon-plus3"></i> Tambah <?= $title ?></button>
        </div>
        <div class="box-body no-padding table-responsive">
            <table class="table-style table text-nowrap">
                <thead>
                    <tr>
                        <th class="text-center">Action</th>
                        <th>Nama Bank</th>
                        <th>Kantor Cabang</th>
                        <th>No Rekening</th>
                        <th>Atasnama</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody id="data"></tbody>
            </table>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
@endsection
@section(script)
<script src="<?= assets() ?>plugins/bootstrap-fileinput/fileinput.min.js"></script>
<script src="<?= assets() ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= assets_js() ?>common.js"></script>
<script src="<?= assets_js() ?>master/rekening.js"></script>
@endsection