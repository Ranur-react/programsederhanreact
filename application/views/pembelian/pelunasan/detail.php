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

    function create(kode) {
        $.ajax({
            url: "<?= site_url('pelunasan/create') ?>",
            type: "GET",
            data: {
                kode: kode
            },
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_create").modal('show');
            }
        });
    }

    $(document).on('submit', '.form_create', function(e) {
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            cache: false,
            beforeSend: function() {
                $('.store_data').button('loading');
            },
            success: function(resp) {
                if (resp.status == "0100") {
                    $('#modal_create').modal('hide');
                    data();
                    toastr.success(resp.message);
                } else {
                    $.each(resp.pesan, function(key, value) {
                        var element = $('#' + key);
                        element.closest('div.form-group')
                            .removeClass('has-error')
                            .addClass(value.length > 0 ? 'has-error' : 'has-success')
                            .find('.help-block')
                            .remove();
                        element.after(value);
                    });
                    toastr.error(resp.message);
                }
            },
            complete: function() {
                $('.store_data').button('reset');
            }
        });
        return false;
    });
</script>