@section(style)
<link rel="stylesheet" href="<?= assets() ?>plugins/iCheck/square/blue.css">
<link rel="stylesheet" href="<?= assets() ?>plugins/toastr/toastr.min.css">
@endsection
@section(content)
<div class="col-xs-12">
    <div class="box box-widget">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('harga') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> <?= $title . ' ' . $data['data']['produk']['produk'] ?>
            </h3>
        </div>
        <div class="box-body">
            <div class="row">
                <?php if ($data['status'] == false) :
                    echo DATA_NOTFOUND;
                else :
                    $num = 1;
                    $limit = 0;
                    foreach ($data['data']['penerimaan'] as $data) {
                        if ($limit >= 3) {
                            echo '</div><div class="row">';
                            $limit = 0;
                        }
                        $limit++;
                ?>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <div class="detail-body">
                                    <div class="detail-header">
                                        <span class="detail-date pull-right"><i class="fa fa-map-marker"></i> Gudang: <?= $data['gudang'] ?></span>
                                        <h4><?= $data['nomor'] ?></h4>
                                        <h5><span class="me-1">Pemasok: <?= $data['pemasok'] ?></span>
                                            <span class="detail-date pull-right"><i class="fa fa-clock-o"></i> <?= $data['tanggal'] ?></span>
                                        </h5>
                                    </div>
                                    <div id="detail-item">
                                        <div class="detail-item with-border">
                                            <div class="item-title">Harga Beli
                                                <span class="pull-right">
                                                    <span><?= $data['hargabeli'] ?></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="detail-item with-border">
                                            <div class="item-title">Jumlah Beli
                                                <span class="pull-right">
                                                    <span><?= $data['jumlah'] ?></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div id="colmd<?= $num ?>">
                                            <?php foreach ($data['dataHarga'] as $dataHarga) { ?>
                                                <div class="detail-item with-border">
                                                    <div class="item-title">
                                                        <?= $dataHarga['jumlahJual'] . ' ' . $dataHarga['satuan']; ?><span style="padding-left:5px;color: rgba(0,0,0,.54)"></span>
                                                        <span class="pull-right">
                                                            <span class="me-2"><?= $dataHarga['hargaText'] ?></span>
                                                            <small class="text-muted me-1"><i class="fa fa-star<?= $dataHarga['default'] == 1 ? ' text-green' : ''; ?>"></i> Default</small>
                                                            <small class="text-muted me-1"><i class="fa fa-clock-o<?= $dataHarga['aktif'] == 1 ? ' text-red' : ''; ?>"></i> Aktif</small>
                                                            <a href="javascript:void(0)" onclick="edit_harga('<?= $dataHarga['idharga']; ?>','<?= $num ?>')">
                                                                <i class="icon-pencil7 text-green" title="Edit"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php $num++;
                    }
                endif; ?>
            </div>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
@endsection
@section(script)
<script src="<?= assets() ?>plugins/iCheck/icheck.min.js"></script>
<script src="<?= assets() ?>plugins/toastr/toastr.min.js"></script>
<script src="<?= assets_js() ?>common.js"></script>
<script>
    function data_harga(iddetail_terima, nourut) {
        $('#colmd' + nourut).html('<p class="text-center m-t-0 m-b-2 text-red"><b><i class="fa fa-refresh animation-rotate"></i> Loading...</b></p>');
        $.ajax({
            url: BASE_URL + 'harga/data-harga',
            method: 'GET',
            dataType: 'json',
            data: {
                iddetail_terima: iddetail_terima
            },
            success: function(resp) {
                // console.log(resp);
                var html = '';
                for (var i = 0; i < resp.length; i++) {
                    if (resp[i]['default'] == '1') {
                        defaults = ' text-green';
                    } else {
                        defaults = '';
                    }
                    if (resp[i]['aktif'] == '1') {
                        aktif = ' text-red';
                    } else {
                        aktif = '';
                    }
                    html += '<div class="detail-item with-border">';
                    html += '<div class="item-title">' + resp[i]['jumlahJual'] + ' ' + resp[i]['satuan'] + '<span style="padding-left:5px;color: rgba(0,0,0,.54)"></span>';
                    html += '<span class="pull-right">';
                    html += '<span class="me-2">' + resp[i]['hargaText'] + '</span>';
                    html += '<small class="text-muted me-1"><i class="fa fa-star' + defaults + '"></i> Default</small>';
                    html += '<small class="text-muted me-1"><i class="fa fa-clock-o' + aktif + '"></i> Aktif</small>';
                    html += '<a href="javascript:void(0)" onclick="edit_harga(\'' + resp[i]['idharga'] + '\',\'' + nourut + '\')"><i class="icon-pencil7 text-green" title="Edit"></i></a>';
                    html += '</span></div></div>';
                }
                $('#colmd' + nourut).html(html);
            }
        });
    }

    function edit_harga(idharga, num) {
        $.ajax({
            url: BASE_URL + 'harga/edit',
            type: 'GET',
            data: {
                idharga: idharga,
                num: num
            },
            success: function(resp) {
                $('#tampil_modal').html(resp);
                $('#modal_create').modal('show');
            }
        });
    }

    $(document).on('submit', '.form_create', function(e) {
        $.ajax({
            type: 'post',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            cache: false,
            beforeSend: function() {
                $('.store_data').button('loading');
            },
            success: function(resp) {
                resetToken(resp.token);
                if (resp.status == '0100') {
                    $('#modal_create').modal('hide');
                    data_harga(resp.iddetail_terima, resp.nourut);
                    toastr.success(resp.pesan);
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
@endsection
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
    // $(document).ready(function() {
    // data_terima();
    // });

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
</script>