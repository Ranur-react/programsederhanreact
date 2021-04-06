<div class="col-xs-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('penerimaan') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Tambah Penerimaan Barang
            </h3>
        </div>
        <input type="hidden" name="id_permintaan" id="id_permintaan">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <button type="button" onclick="data_permintaan()" class="btn btn-social btn-block btn-flat btn-primary btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i class="icon-folder-search"></i> Cari data permintaan barang</button>
                    <div id="fetch_popupuk"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
<script>
    function data_permintaan() {
        $.ajax({
            url: "<?= site_url('penerimaan/tmp-create/modal-permintaan') ?>",
            type: "GET",
            success: function(reps) {
                $("#tampil_modal").html(reps);
                $("#modal_data").modal('show');
            }
        });
    }

    function pilih(id_permintaan) {
        $("#id_permintaan").val(id_permintaan);
        $('#modal_data').modal('hide');
    }
</script>