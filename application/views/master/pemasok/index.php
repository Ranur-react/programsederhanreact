@section(style)
<link rel="stylesheet" href="<?= assets() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection
@section(content)
<div class="col-xs-12">
	<div class="box box-default">
		<div class="box-header with-border">
			<button class="btn btn-social btn-flat btn-success btn-sm" onclick="create()"><i class="icon-plus3"></i> Tambah <?= $title ?></button>
		</div>
		<div class="box-body table-responsive">
			<table class="table table-bordered table-striped data-pemasok">
				<thead>
					<tr>
						<th class="text-center" width="40px">No.</th>
						<th>Nama</th>
						<th>Alamat</th>
						<th>Telepon</th>
						<th width="100px">Jenis</th>
						<th class="text-center" width="60px">Action</th>
					</tr>
				</thead>
				<tbody></tbody>
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
<script src="<?= assets_js() ?>common.js"></script>
<script src="<?= assets_js() ?>master/pemasok.js"></script>
@endsection