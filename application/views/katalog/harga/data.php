<div class="row">
    <?php $limit = 0;
    foreach ($data as $result) {
        if ($limit >= 2) {
            echo '</div><div class="row">';
            $limit = 0;
        }
        $limit++;
    ?>
        <div class="col-md-6">
            <div class="detail-card">
                <div class="detail-body<?= $result['default'] == '1' ? ' active' : '' ?>">
                    <div class="detail-header">
                        <h4><?= $result['barang']; ?></h4>
                        <h5><span class="me-1">id_terima: <?= $result['id_terima'] . ' id_harga: ' . $result['id_harga']; ?></span><span class="me-1"><?= $result['tanggal']; ?></span>dari: <?= $result['supplier']; ?>
                            <span class="detail-date pull-right"><i class="fa fa-clock-o"></i> <?= $result['created_at'] ?></span>
                        </h5>
                    </div>
                    <div id="detail-item<?= $result['id_harga']; ?>">
                        <?php
                        $result_harga = $result['data_harga'];
                        foreach ($result_harga as $rh) {
                        ?>
                            <div class="detail-item with-border">
                                <div class="item-title">
                                    <?= $rh['satuan']; ?>
                                    <span class="pull-right">
                                        <span class="me-2"><?= $rh['id_detail'] ?> <?= rupiah($rh['harga']) . ' ' . $rh['singkatan']; ?></span>
                                        <a href="javascript:void(0)">
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
    <?php } ?>
</div>