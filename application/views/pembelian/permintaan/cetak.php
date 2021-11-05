<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        @page {
            size: auto;
            margin: 4mm;
            /*margin: 5.3mm;*/
        }

        @media print {
            /* @page {
                size: landscape;
            } */

            #action-area {
                display: none;
            }
        }

        body {
            font-family: "Calibri";
        }

        table {
            width: 100%;
        }

        .text-title {
            font-weight: bold;
            font-size: 0.875rem;
        }

        .hr-number {
            border-top: 1px solid #000;
            margin-top: 4px;
            margin-bottom: 0px;
        }

        .hr-ttd {
            border-top: 1px solid #000;
            margin-top: 0;
            margin-bottom: 0;
        }

        .text-data {
            font-size: 0.75rem;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .m-t-1 {
            margin-top: 10px;
        }

        .tabel-item {
            font-size: 0.75rem;
        }
    </style>
</head>

<body onload="window.print()">
    <table align="center" border="0" cellspacing="0" cellpading="0">
        <thead>
            <tr>
                <td class="text-left" colspan="6">
                    <div class="text-title">BARANGMUDO</div>
                </td>
                <th colspan="3" width="35%">
                    <div class="text-title">FAKTUR PERMINTAAN PRODUK</div>
                    <hr class="hr-number">
                </th>
            </tr>
            <tr>
                <td class="text-data" width="30px" style="vertical-align: top;">No. PO</td>
                <td class="text-center text-data" width="10px" style="vertical-align: top;">:</td>
                <td class="text-data" style="vertical-align: top;"><?= $data['nomor'] ?></td>
            </tr>
            <tr>
                <td class="text-data">Tanggal</td>
                <td class="text-center text-data" width="10px">:</td>
                <td class="text-data"><?= $data['tanggal_format'] ?></td>
            </tr>
        </thead>
    </table>
    <div class="m-t-1"></div>
    <table class="tabel-item" border="0">
        <thead>
            <tr>
                <td colspan="6" style="border-bottom: thin solid;border-color: black;padding-top: 0;padding-bottom: 0;"></td>
            </tr>
            <tr>
                <th class="text-center" width="30px">No</th>
                <th class="text-center">Nama Produk</th>
                <th class="text-center" width="140px">Satuan</th>
                <th class="text-right" width="150px">Harga</th>
                <th class="text-right" width="120px">Jumlah</td>
                <th class="text-right" width="150px">Total</td>
            </tr>
            <tr>
                <td colspan="6" style="border-bottom: thin solid;border-color: black;padding-top: 0;padding-bottom: 0;"></td>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data['dataProduk'] as $d) { ?>
                <tr>
                    <td class="text-center" style="padding-top: 0px; padding-bottom: 0px"><?= $no . '.' ?></td>
                    <td style="padding-top: 0px; padding-bottom: 0px"><?= $d['produk'] ?></td>
                    <td class="text-center" style="padding: 0 4px 0 4px;"><?= $d['satuan'] ?></td>
                    <td class="text-right" style="padding: 0 4px 0 4px"><?= $d['hargaText'] ?></td>
                    <td class="text-right" style="padding: 0 4px 0 4px"><?= $d['jumlahProduk'] ?></td>
                    <td class="text-right" style="padding: 0 4px 0 4px"><?= $d['totalText'] ?></td>
                </tr>
            <?php $no++;
            } ?>
            <tr>
                <td class="text-center" style="padding-top: 0px; padding-bottom: 0px">&nbsp;</td>
                <td style="padding-top: 0px; padding-bottom: 0px"></td>
                <td class="text-right" style="padding: 0 4px 0 4px"></td>
                <td style="padding: 0 4px 0 4px;"></td>
                <td style="padding: 0 4px 0 4px;"></td>
                <td style="padding: 0 4px 0 4px;"></td>
            </tr>
            <tr>
                <td colspan="6" style="border-bottom: thin solid;border-color: black;"></td>
            </tr>
            <tr>
                <th class="text-right" colspan="5">Total</td>
                <th class="text-right"><?= $data['totalText'] ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>