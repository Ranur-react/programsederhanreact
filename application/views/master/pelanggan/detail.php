@section(style)
<link rel="stylesheet" href="<?= assets_css() ?>detail-user.css">
@endsection
@section(content)
<div class="col-md-10 col-md-offset-1">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a class="text-back" href="<?= site_url('pelanggan') ?>" title="Kembali"><i class="icon-arrow-left8" style="font-size: 24px"></i></a> Detail Pelanggan
            </h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default" style="margin-bottom: 0;">
                <div class="panel-body panel-body-custom">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 ">
                            <p class="css-sc99uv">Biodata Diri</p>
                            <div class="row">
                                <div class="col-md-2 css-57ekgf">Nama</div>
                                <div class="col-md-10 css-57ekgf"><?= $data['nama'] ?></div>
                                <div class="col-md-2 css-57ekgf">Email</div>
                                <div class="col-md-10 css-57ekgf"><?= $data['email'] ?></div>
                                <div class="col-md-2 css-57ekgf">No Ponsel</div>
                                <div class="col-md-10 css-57ekgf"><?= $data['phone'] ?></div>
                                <div class="col-md-2 css-57ekgf">Tanggal Lahir</div>
                                <div class="col-md-10 css-57ekgf"><?= $data['birth'] != null ? format_biasa($data['birth']) : date('d-m-Y') ?></div>
                                <div class="col-md-2 css-57ekgf">Jenis Kelamin</div>
                                <div class="col-md-10 css-57ekgf"><?= $data['jenkel'] == 1 ? 'Pria' : 'Wanita' ?></div>
                                <div class="col-md-2 css-57ekgf">Status</div>
                                <div class="col-md-10 css-57ekgf"><?= status_label($data['status'], 'aktif') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="css-g1ki3s">
                <div class="detail-title">Daftar Alamat</div>
                <div class="activity-list">
                    <?php if ($data['dataAlamat'] != null) :
                        foreach ($data['dataAlamat'] as $da) { ?>
                            <div class="activity-item">
                                <!-- <img width="38" src="https://ecs7.tokopedia.net/img/user/setting/icon-phone-green.svg" alt="device-logo"> -->
                                <div class="activity-detail">
                                    <div class="device-name"><?= $da['penerima'] ?></div>
                                    <div class="device-location"><?= $da['telp'] ?></div>
                                    <div class="device-location"><?= $da['detail'] ?></div>
                                    <!-- <div class="is-active">Sedang aktif</div> -->
                                </div>
                            </div>
                            <div class="css-1pkd43o"></div>
                        <?php }
                    else :
                        echo  info('belum ada data bank') ?>
                    <?php endif; ?>
                </div>
                <div class="detail-title">Daftar Bank</div>
                <?php if ($data['dataBank'] != null) :
                    foreach ($data['dataBank'] as $db) { ?>
                        <div class="css-1osydf3 ei0wc5h2">
                            <!-- <div class="css-2ao6n4"><img class="css-9whsf3" src="https://ecs7.tokopedia.net/img/icon-bca.gif" alt="PT. BCA (BANK CENTRAL ASIA) TBK" data-testid="sba-bank-item-logo"></div> -->
                            <div>
                                <div class="css-1avvj1m" data-testid="sba-bank-item-name"><?= $db['bank'] ?></div>
                                <div data-testid="sba-bank-item-account">
                                    <div>
                                        <div class="css-16l6s7r"><?= $db['norek'] ?></div>
                                    </div>
                                    <div class="css-15b1fts">a.n <strong><?= $db['pemilik'] ?></strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="css-1pkd43o"></div>
                    <?php }
                else :
                    echo  info('belum ada data bank') ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
@endsection