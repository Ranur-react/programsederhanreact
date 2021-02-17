<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{title}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="<?= faviconApp() ?>">
    <link rel="stylesheet" href="<?= assets() ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= assets() ?>bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= assets() ?>bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= assets() ?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= assets() ?>plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script src="<?= assets() ?>bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= assets() ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= assets() ?>plugins/iCheck/icheck.min.js"></script>
    <style>
        .login-box {
            margin: 5% auto;
        }

        .login-logo img {
            width: 120px;
            height: 130px;
        }

        .login-box-msg,
        .register-box-msg {
            font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 600;
            font-size: 16px;
        }

        .btn-success {
            color: #fff;
            border-color: #44a548;
        }

        .btn-success {
            background: #50b755;
        }

        .btn-success:active:hover {
            color: #fff;
            background-color: #419d45;
            border-color: #358139;
        }

        .btn-success:hover,
        .btn-success:active,
        .btn-success.hover {
            background-color: #419d45;
        }

        .btn-danger {
            color: #fff;
            border-color: #ca5e51;
        }

        .btn-danger {
            background: #e46050;
        }

        .btn-danger:active:hover {
            color: #fff;
            background-color: #e46050;
            border-color: #b14336;
        }

        .btn-danger:hover,
        .btn-danger:active,
        .btn-danger.hover {
            background-color: #e04835;
        }

        .text-muted,
        .text-muted a,
        .text-muted:active,
        .text-muted:focus,
        .text-muted:hover,
        .text-muted[href] {
            color: #818a91 !important;
        }

        .form-control {
            border-radius: 3px;
        }
    </style>
</head>

<body class="hold-transition login-page">
    {content}
</body>

</html>