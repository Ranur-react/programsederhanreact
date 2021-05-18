<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><a href="<?= site_url('penerimaan') ?>" class="text-back" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Rincian Pelunasan Penerimaan</h3>
            </div>
            <div class="box-body">
                <input type="hidden" id="idterima" value="<?= $data['id_terima']; ?>">
                <div id="data-bayar"></div>
            </div>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
<script>
    $(document).ready(function() {
        data();
    });

    function data() {
        var idterima = $('#idterima').val();
        $('#data-bayar').html('<p class="text-center m-t-0 m-b-2 text-red"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></p>');
        $.ajax({
            url: "<?= site_url('pelunasan/data') ?>",
            method: "GET",
            data: {
                idterima: idterima
            },
            success: function(resp) {
                $('#data-bayar').html(resp);
            }
        });
    }
</script>