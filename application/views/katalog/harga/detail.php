<?php
if ($data['status'] == true) {
    echo info('Data harga jual yang ditampilkan diaplikasi mobile.'); ?>
    <div class="detail-card">
        <div class="detail-body">
            <div class="detail-header">
                <span class="detail-date pull-right"><i class="fa fa-clock-o"></i> <?= $data['data']['tanggal'] ?></span>
                <h4><?= $data['data']['produk']; ?></h4>
                <h5>
                    <span class="me-1"><?= $data['data']['nomor']; ?></span>
                    <span class="me-1"><?= $data['data']['tanggal'] ?></span>
                    <span>dari: <?= $data['data']['pemasok']; ?></span>
                    <span class="pull-right">Harga beli: <?= $data['data']['hargaBeli'] ?></span>
                </h5>
            </div>
            <?php foreach ($data['data']['dataSatuan'] as $ds) { ?>
                <div class="detail-item with-border">
                    <div class="item-title">
                        <?= $ds['jumlahProduk'] . ' ' . $ds['satuan'] . $ds['warning'] ?>
                        <span class="pull-right">
                            <span class="me-2"><?= $ds['hargaText'] ?></span>
                            <small class="text-muted me-1"><i class="fa fa-star<?= $ds['default'] == 1 ? ' text-green' : ''; ?>"></i> Default</small>
                            <small class="text-muted"><i class="fa fa-clock-o<?= $ds['aktif'] == 1 ? ' text-red' : ''; ?>"></i> Aktif</small>
                        </span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } else {
    echo info('Harga belum diaktifkan.');
} ?>