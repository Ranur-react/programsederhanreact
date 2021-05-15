<div class="col-xs-12">
    <div class="box box-widget">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('harga') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Kelola Harga Jual Barang
            </h3>
        </div>
        <div class="box-body">
            <input type="hidden" id="kode" value="<?= $kode; ?>">
            <div id="data"></div>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
<script>
    $(document).ready(function() {
        data_terima();
    });

    function data_terima() {
        var kode = $('#kode').val();
        $('#data').html('<p class="text-center m-t-0 m-b-2 text-red"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></p>');
        $.ajax({
            url: "<?= site_url('harga/data-terima') ?>",
            method: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $('#data').html(resp);
            }
        });
    }

    function add_satuan(id_satuan, id_harga) {
        $.ajax({
            url: "<?= site_url('harga/add-satuan') ?>",
            type: "GET",
            dataType: "json",
            data: {
                id_satuan: id_satuan,
                id_harga: id_harga
            },
            success: function(resp) {
                data_terima();
                toastr.success(resp.message);
            }
        });
    }

    function edit_harga(id_detail) {
        $.ajax({
            url: "<?= site_url('harga/edit-harga') ?>",
            type: "GET",
            data: {
                id_detail: id_detail
            },
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }
</script>