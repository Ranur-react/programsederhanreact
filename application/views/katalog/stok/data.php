<div class="row">
    <?php $limit = 0;
    foreach ($data as $d) {
        if ($limit >= 2) {
            echo '</div><div class="row">';
            $limit = 0;
        }
        $limit++;
    ?>
        <div class="col-md-6">
            <div class="detail-card">
                <div class="detail-body">
                    <div class="detail-header">
                        <span class="detail-date pull-right"><i class="fa fa-map-marker"></i> Gudang: <?= $d['gudang'] ?></span>
                        <h4><?= $d['barang'] ?></h4>
                        <h5><span class="me-1"><?= $d['nomor'] ?></span>dari: <?= $d['supplier'] ?>
                            <span class="detail-date pull-right"><i class="fa fa-clock-o"></i> <?= $d['created_at'] ?></span>
                        </h5>
                    </div>
                    <div id="detail-item">
                        <div class="detail-item with-border">
                            <div class="item-title">Jumlah Beli
                                <span class="pull-right">
                                    <span><?= $d['jumlah_beli'] . ' ' . $d['satuan_beli'] ?></span>
                                </span>
                            </div>
                        </div>
                        <div class="detail-item with-border">
                            <div class="item-title">Stok Tersedia
                                <span class="pull-right">
                                    <span><?= $d['stok'] . ' ' . $d['satuan_beli'] ?></span>
                                </span>
                            </div>
                        </div>
                        <div class="detail-item with-border">
                            <div class="item-title">Stok Terjual
                                <span class="pull-right">
                                    <span><?= $d['terjual'] . ' ' . $d['satuan_beli'] ?></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>