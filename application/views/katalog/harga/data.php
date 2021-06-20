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
                        <h5><span class="me-1"><?= $result['nomor']; ?></span><span class="me-1"><?= $result['tanggal']; ?></span>dari: <?= $result['supplier']; ?>
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
                                    <?= rupiah($rh['berat']) . ' ' . $rh['satuan']; ?><span style="padding-left:5px;color: rgba(0,0,0,.54)"><?= $rh['berat'] == 0 ? '(Berat belum dirubah)' : null ?></span>
                                    <span class="pull-right">
                                        <span class="me-2">Rp <?= rupiah($rh['harga']); ?></span>
                                        <small class="text-muted me-1"><i class="fa fa-clock-o<?= $rh['default'] == 1 ? ' text-green' : ''; ?>"></i> Default</small>
                                        <small class="text-muted me-1"><i class="fa fa-clock-o<?= $rh['aktif'] == 1 ? ' text-red' : ''; ?>"></i> Aktif</small>
                                        <a href="javascript:void(0)" onclick="edit_harga('<?= $rh['id_detail']; ?>')">
                                            <i class="icon-pencil7 text-green" title="Edit"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        $result_satuan = $result['data_satuan'];
                        foreach ($result_satuan as $rs) {
                        ?>
                            <div class="detail-item with-border" id="detail-satuan<?= $rs['id_satuan']; ?>">
                                <div class="item-title">
                                    <?= $rs['nama_satuan']; ?>
                                    <span class="pull-right">
                                        <a href="javascript:void(0)" onclick="add_satuan('<?= $rs['id_satuan']; ?>','<?= $result['id_harga']; ?>')">
                                            <i class="icon-plus-circle2 text-black" title="Tambah"></i>
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