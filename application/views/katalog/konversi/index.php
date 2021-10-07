@section(content)
<div class="col-xs-12">
    <div class="box box-default">
        <div class="box-header with-border">
            <button class="btn btn-social btn-flat btn-success btn-sm create"><i class="icon-plus3"></i> Tambah Konversi Satuan</button>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center" width="80px">Action</th>
                        <th width="250px">Konversi Satuan</th>
                        <th>Nilai Konversi</th>
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
<script src="<?= assets() ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= assets_js() ?>common.js"></script>
<script src="<?= assets_js() ?>katalog/konversi.js"></script>
@endsection