<html lang="id">

<head>
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }

        @media print {
            body {
                padding-top: 0;
            }

            #action-area {
                display: none;
            }
        }

        @media screen and (min-width: 1025px) {
            .btn-download {
                display: none !important;
            }

            .btn-back {
                display: none !important;
            }
        }

        @media screen and (max-width: 1024px) {
            .content-area>div {
                width: auto !important;
            }

            .btn-print {
                display: none !important;
            }
        }

        @media screen and (max-width: 720px) {
            .content-area>div {
                width: auto !important;
            }
        }

        @media screen and (max-width: 420px) {
            .content-area>div {
                width: 790px !important;
            }
        }

        @media screen and (max-width: 430px) {
            .content-area {
                transform: scale(0.59) translate(-35%, -35%)
            }

            .content-area>div {
                width: 720px !important;
            }

            .btn-print {
                display: none !important;
            }
        }

        @media screen and (max-width: 380px) {
            .content-area {
                transform: scale(0.45) translate(-58%, -62%);
            }

            .content-area>div {
                width: 790px !important;
            }

            .btn-print {
                display: none !important;
            }
        }

        @media screen and (max-width: 320px) {
            .content-area>div {
                width: 700px !important;
            }
        }
    </style>
</head>

<body style="font-family: open sans, tahoma, sans-serif; margin: 0; -webkit-print-color-adjust: exact; padding-top: 60px;">

    <div id="action-area">
        <div id="navbar-wrapper" style="padding: 12px 16px;font-size: 0;line-height: 1.4; box-shadow: 0 -1px 7px 0 rgba(0, 0, 0, 0.15); position: fixed; top: 0; left: 0; width: 100%; background-color: #FFF; z-index: 100;">
            <div style="width: 50%; display: inline-block; vertical-align: middle; font-size: 12px;">
                <div class="btn-back" onclick="window.close();">
                    <img src="https://ecs7.tokopedia.net/img/back-invoice.png" width="20px" alt="Back" style="display: inline-block; vertical-align: middle;">
                    <span style="display: inline-block; vertical-align: middle; margin-left: 16px; font-size: 16px; font-weight: bold; color: rgba(49, 53, 59, 0.96);">Invoice</span>
                </div>
            </div>
            <div style="width: 50%; display: inline-block; vertical-align: middle; font-size: 12px; text-align: right;">
                <a class="btn-download" href="javascript:window.print()" style="display: inline-block; vertical-align: middle;">
                    <img src="https://ecs7.tokopedia.net/img/download-invoice.png" alt="Download" width="20px" ;="">
                </a>
                <a class="btn-print" href="javascript:window.print()" style="height: 100%; display: inline-block; vertical-align: middle;">
                    <button id="print-button" style="border: none; height: 100%; cursor: pointer;padding: 8px 40px;border-color: #d60101;border-radius: 8px;background-color: #d60101;margin-left: 16px;color: #fff;font-size: 12px;line-height: 1.333;font-weight: 700;">Cetak</button>
                </a>
            </div>
        </div>
    </div>
    <div class="content-area">
        <div style="background-size: contain; margin: auto; width: 790px;">
            <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; padding: 25px 32px; color: #343030;">
                <tbody>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" style="padding-bottom: 20px; border-bottom: thin dashed #cccccc;">
                                <tbody>
                                    <tr>
                                        <td style="width: 57%; vertical-align: top;">
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2">
                                                            <img src="<?= assets() ?>logo/logo-red.png" alt="Tokopedia" style="margin-bottom: 15px;">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2" style="font-size: 14px;">
                                                            <span style="font-weight: 600">Nomor Invoice</span> : <span style="color: #d60101; font-weight: 600;"><?= $data['nomor'] ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 12px; font-weight: 600; padding: 8px 0; width: 80px;">Customer</td>
                                                        <td style="font-size: 12px; padding: 8px 0;"><?= $data['customer'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 12px; font-weight: 600; padding-bottom: 6px; width: 80px;">
                                                            Tanggal</td>
                                                        <td style="font-size: 12px; padding-bottom: 6px;">
                                                            <?= format_indo(format_tglen_timestamp($data['tanggal'])) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width: 43%; vertical-align: top; padding-left: 30px;">
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-weight: 600; font-size: 14px;padding-bottom: 8px;">
                                                            Tujuan Pengiriman:</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 12px; padding-bottom: 20px;">
                                                            <span style="margin-bottom: 3px; font-weight: 600; display: block;"><?= $pengiriman['penerima'] ?></span>
                                                            <div>
                                                                <?= $pengiriman['alamat'] ?><br>
                                                                <?= $pengiriman['kota'] . ', ' . $pengiriman['pos'] ?><br>
                                                                Sumatera Barat <br>
                                                                <?= $pengiriman['telp'] ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="0" style="border: thin dashed rgba(0, 0, 0, 0.34); border-radius: 4px; color: #343030; margin-top: 20px;">
                                <tbody>
                                    <tr style="background-color: rgba(242, 242, 242, 0.74); font-size: 14px; font-weight: 600;">
                                        <td style="padding: 10px 15px;">Nama Produk</td>
                                        <td style="padding: 10px 15px; text-align: center;">Jumlah</td>
                                        <td style="padding: 10px 15px; text-align: center;">Berat</td>
                                        <td style="padding: 10px 15px; text-align: center; white-space: nowrap;">Harga
                                            Barang</td>
                                        <td style="padding: 10px 15px; text-align: right;">Subtotal</td>
                                    </tr>
                                    <?php $total = 0;
                                    foreach ($produk['data'] as $p) {
                                        $total = $total + $p['total'];
                                    ?>
                                        <tr style="font-size: 14px;">
                                            <td width="330" style="padding: 15px; font-weight: 600; word-break: break-word;"><?= $p['produk'] ?></td>
                                            <td valign="top" style="padding: 15px; text-align: center;"><?= rupiah($p['jumlah']) ?></td>
                                            <td valign="top" style="padding: 15px; text-align: center; white-space: nowrap;"><?= rupiah($p['berat']) . ' ' . $p['singkat'] ?></td>
                                            <td valign="top" style="padding: 15px; white-space: nowrap; text-align: center;">Rp <?= rupiah($p['harga']) ?></td>
                                            <td valign="top" style="padding: 15px; white-space: nowrap;">Rp <?= rupiah($p['total']) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="5" style="padding: 0 15px;">
                                            <div style="border-bottom: thin solid #e0e0e0"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="4">
                                            <table width="100%" cellspacing="0" cellpadding="0" style="padding-right: 15px; font-size: 14px; font-weight: 600;">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div style="border-bottom: thin solid #e0e0e0"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 15px;">Subtotal Harga Barang</td>
                                                        <td style="padding: 15px 0 15px 15px; text-align: right;">Rp <?= rupiah($total) ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- refactor div float left and right in case order is kelontong -->
                    <tr>
                        <td>
                            <div id="container_invoice_qr" style="float:left; font-weight: bold;
                                    margin-top:20px;">

                            </div>

                            <div style="float:right;">
                                <table>
                                    <!-- subtotal ongkir -->
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table width="100%" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 50%;"></td>
                                                            <td style="width: 50%;">
                                                                <table width="100%" style="width: 430px; margin-top: 15px; padding: 15px; border-radius: 4px; border: thin solid rgba(0, 0, 0, 0.54); font-size: 14px; font-weight: 600;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Total Bayar</td>
                                                                            <td style="text-align: right;">Rp <?= rupiah($total) ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                        <!-- Keterangan -->

                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script type="text/javascript" src="/cRPyEmyezvRd-Vggbbqt/3a7SXGLb/YXVAWAE/elxMRT/gANx4"></script>

    <script src="https://cdn.tokopedia.net/built/d1dd3126ee9ae2b8381ed123ca34b2a2.js" type="text/javascript"></script>
    <script src="https://cdn.tokopedia.net/built/6b42e5043225d4bd57fb1d885f07b835.js" type="text/javascript"></script>

    <script type="text/javascript">
        jQuery(document).ready(function(event) {

            var qrcode = new QRCode("invoice_qr", {
                text: "",
                width: 200,
                height: 200,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            $('#invoice_qr').on('contextmenu', 'img', function(e) {
                return false;
            });
        });
    </script>

</body>

</html>