<link rel="stylesheet" href="<?= assets() ?>css/card.css" />
<div class="col-xs-12">
    <div class="css-1vcaoba">
        <div class="css-ffnekd">
            <div class="css-1nn2x58">
                <div class="css-97cyn8">
                    <div class="css-3r5h64">
                        <div class="css-k0nmra">
                            <img class="css-mnywuz" src="<?= assets() ?>images/report.png">
                            <div class="css-porh3">
                                <h3 data-id="lblProfileName">Data Permintaan</h3>
                            </div>
                            <div class="css-1bmrgqt"></div>
                        </div>
                    </div>
                </div>
                <div class="css-1bo6mi5">
                    <a href="<?= site_url('laporan/permintaan/cetak') ?>" target="_blank" class="css-w954na-unf-btn e1ggruw00"><span>Lihat Laporan</span></a>
                </div>
            </div>
        </div>
        <div class="css-ffnekd">
            <div class="css-1nn2x58">
                <div class="css-97cyn8">
                    <div class="css-3r5h64">
                        <div class="css-k0nmra">
                            <img class="css-mnywuz" src="<?= assets() ?>images/report.png">
                            <div class="css-porh3">
                                <h3 data-id="lblProfileName">Permintaan Perperiode</h3>
                            </div>
                            <div class="css-1bmrgqt"></div>
                        </div>
                    </div>
                </div>
                <div class="css-1bo6mi5">
                    <a href="javascript:void(0)" onclick="modal_perperiode()" class="css-w954na-unf-btn e1ggruw00"><span>Lihat Laporan</span></a>
                </div>
            </div>
        </div>
        <div class="css-ffnekd">
            <div class="css-1nn2x58">
                <div class="css-97cyn8">
                    <div class="css-3r5h64">
                        <div class="css-k0nmra">
                            <img class="css-mnywuz" src="<?= assets() ?>images/report.png">
                            <div class="css-porh3">
                                <h3 data-id="lblProfileName">Permintaan Perbulan</h3>
                            </div>
                            <div class="css-1bmrgqt"></div>
                        </div>
                    </div>
                </div>
                <div class="css-1bo6mi5">
                    <a href="javascript:void(0)" onclick="modal_perbulan()" class="css-w954na-unf-btn e1ggruw00"><span>Lihat Laporan</span></a>
                </div>
            </div>
        </div>
        <div class="css-ffnekd">
            <div class="css-1nn2x58">
                <div class="css-97cyn8">
                    <div class="css-3r5h64">
                        <div class="css-k0nmra">
                            <img class="css-mnywuz" src="<?= assets() ?>images/report.png">
                            <div class="css-porh3">
                                <h3 data-id="lblProfileName">Permintaan Pertahun</h3>
                            </div>
                            <div class="css-1bmrgqt"></div>
                        </div>
                    </div>
                </div>
                <div class="css-1bo6mi5">
                    <a href="javascript:void(0)" onclick="modal_pertahun()" class="css-w954na-unf-btn e1ggruw00"><span>Lihat Laporan</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tampil_modal"></div>
<script>
    function modal_perperiode() {
        $.ajax({
            url: "<?= site_url('laporan/permintaan/modal_perperiode') ?>",
            type: "GET",
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_report").modal('show');
            }
        });
    }

    function modal_perbulan() {
        $.ajax({
            url: "<?= site_url('laporan/permintaan/modal_perbulan') ?>",
            type: "GET",
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_report").modal('show');
            }
        });
    }

    function modal_pertahun() {
        $.ajax({
            url: "<?= site_url('laporan/permintaan/modal_pertahun') ?>",
            type: "GET",
            success: function(resp) {
                $("#tampil_modal").html(resp);
                $("#modal_report").modal('show');
            }
        });
    }
</script>