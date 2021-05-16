<?php
if ($data != null) {
    echo info('Data harga jual yang ditampilkan diaplikasi mobile.');
    foreach ($data as $result) { ?>
        <div class="detail-card">
            <div class="detail-body">
                <div class="detail-header">
                    <h4><?= $result['barang']; ?></h4>
                    <h5><span class="me-1"><?= $result['id_terima']; ?></span><span class="me-1"><?= $result['tanggal']; ?></span>dari: <?= $result['supplier']; ?>
                        <span class="detail-date pull-right"><i class="fa fa-clock-o"></i> <?= $result['created_at']; ?></span>
                    </h5>
                </div>
                <?php
                $result_harga = $result['data_harga'];
                foreach ($result_harga as $rh) {
                ?>
                    <div class="detail-item with-border">
                        <div class="item-title"><?= $rh['satuan']; ?>
                            <span class="pull-right"><?= rupiah($rh['harga']) . ' ' . $rh['singkatan']; ?></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
<?php }
} else {
    echo info('Harga belum diaktifkan.');
} ?>