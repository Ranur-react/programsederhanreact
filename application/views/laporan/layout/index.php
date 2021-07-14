<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="<?= faviconApp() ?>">
    <style>
        * {
            font-family: "open sans", tahoma, sans-serif;
            margin-left: auto;
            margin-right: auto;
        }

        .tabel-header,
        .tabel-data,
        .tabel-footer {
            width: 100%;

        }

        .tabel-header td,
        .tabel-footer td {
            font-size: 11pt;
        }

        .tabel-header td.tabel-header-title {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            padding: 10px 0 10px 0;
        }

        .tabel-data {
            margin-top: 10px;
            color: #232323;
            border-collapse: collapse;
        }

        .tabel-data,
        .tabel-data th,
        .tabel-data td {
            font-size: 11pt;
            border: 1px solid #000;
            padding: 5px 5px;
        }

        .tabel-footer {
            margin-top: 10px;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <table class="tabel-header" style="padding-bottom: 15px;">
        <tbody>
            <tr style="text-align: right;">
                <td rowspan="3" style="width: 20%">
                    <img src="<?= assets() ?>logo/logo.png" width="84px" height="90px">
                </td>
                <td></td>
                <td rowspan="3" style="width: 20%"></td>
            </tr>
            <tr>
                <td style="font-size: 18pt;font-family: Arial;font-weight:bolder;font-style:normal;text-align: center; width: 60%">Barangmudo</td>
            </tr>
            <tr>
                <td style="font-size: 14pt;font-family: Arial;text-align: center;font-weight:bolder;"><?= $title ?></td>
            </tr>
        </tbody>
    </table>
    <?= $content ?>
</body>

</html>