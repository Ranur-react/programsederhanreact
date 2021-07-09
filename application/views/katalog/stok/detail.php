<div class="col-xs-12">
    <div class="box box-widget">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('stok-barang') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Stok Barang
            </h3>
        </div>
        <div class="box-body">
            <input type="hidden" id="kode" value="<?= $kode; ?>">
            <div id="data"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        load_data();
    });

    function load_data() {
        var kode = $('#kode').val();
        $('#data').html('<p class="text-center m-t-0 m-b-2 text-red"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></p>');
        $.ajax({
            url: "<?= site_url('stok-barang/data-terima') ?>",
            method: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $('#data').html(resp);
            }
        });
    }
</script>