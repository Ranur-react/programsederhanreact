@section(content)
<div class="col-xs-12">
    <div class="box box-widget">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('stok-produk') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> <?= $title . ' ' . $data['data']['produk']['produk'] ?>
            </h3>
        </div>
        <div class="box-body">
            <div class="row">
                <?php if ($data['status'] == false) :
                    echo DATA_NOTFOUND;
                else :
                    foreach ($data['data']['penerimaan'] as $data) { ?>
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
                                        <div class="detail-item with-border">
                                            <div class="item-title">Stok Tersedia
                                                <span class="pull-right">
                                                    <span><?= $data['stok'] ?></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="detail-item with-border">
                                            <div class="item-title">Terjual
                                                <span class="pull-right">
                                                    <span><?= $data['terjual'] ?></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php }
                endif; ?>
            </div>
        </div>
    </div>
</div>
@endsection