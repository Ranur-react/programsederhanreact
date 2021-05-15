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
                    data_terima();
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
                }
            },
            complete: function() {
                $('.store_data').button('reset');
            }
        });
        return false;
    });
</script>