<script>
	$(function() {
		$('.datepicker').datepicker({
			autoclose: true
		});
		$('input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		})
	});
</script>
<div class="modal fade" id="modal_edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Update Data</h4>
			</div>
			<?= form_open('master/Supplier/update', ['id' => 'edit', 'class' => 'form_edit'], ['kode' => $data['id_supplier']]) ?>
			<div class="modal-body">

				<div class="form-group">
					<label>Id Supplier</label>
					<input type="text" name="idsupplier" class="form-control"  value="<?= $data['id_supplier'] ?>">
					<span class="error idsupplier text-red"></span>
				</div>

				<div class="form-group">
					<label>Nama Supplier</label>
					<input type="text" name="namasupplier" class="form-control"  value="<?= $data['nama_supplier'] ?>">
					<span class="error namasupplier text-red"></span>
				</div>

				<div class="form-group">
					<label>Alamat Supplier</label>
					<input type="text" name="alamatsupplier" class="form-control"  value="<?= $data['alamat_supplier'] ?>">
					<span class="error alamatsupplier text-red"></span>
				</div>

				<div class="form-group">
					<label>Telpon Supplier</label>
					<input type="text" name="telpsupplier" class="form-control"  value="<?= $data['telp_supplier'] ?>">
					<span class="error telpsupplier text-red"></span>
				</div>

				
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary btnUpdate"><i class="icon-floppy-disk"></i> Update</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icon-cross2"></i> Close</button>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>
<script>
	$(document).on('submit', '.form_edit', function(e) {
		$.ajax({
			type: "post",
			url: $(this).attr('action'),
			data: $(this).serialize(),
			dataType: "json",
			cache: false,
			beforeSend: function() {
				$('.btnUpdate').attr('disabled', 'disabled');
				$('.btnUpdate').html('<i class="fa fa-spin fa-spinner"></i> Sedang di Proses');
			},
			success: function(response) {
				$('.error').html('');
				if (response.status == false) {
					$.each(response.pesan, function(i, m) {
						$('.' + i).text(m);
					});
				} else {
					window.location.href = "<?= site_url('sup') ?>";
				}
			},
			complete: function() {
				$('.btnUpdate').removeAttr('disabled');
				$('.btnUpdate').html('<i class="icon-floppy-disk"></i> Update');
			}
		});
		return false;
	});
</script>
