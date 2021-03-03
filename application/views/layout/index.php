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
    <link rel="stylesheet" href="<?= assets() ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?= assets() ?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= assets() ?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?= assets() ?>bower_components/icomoon/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script src="<?= assets() ?>bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= assets() ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="<?= assets() ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= assets() ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= assets() ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= assets() ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <script src="<?= assets() ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= assets() ?>bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?= assets() ?>dist/js/adminlte.min.js"></script>
    <script src="<?= assets() ?>dist/js/demo.js"></script>
    <script src="<?= assets() ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script>
        $(function() {
            $('#data-tabel').DataTable({
                ordering: false
            })
        });
    </script>
    <style>
        .dropdown-menu>li>a {
            padding: 10px 20px;
        }

        .modal-content {
            border-radius: 5px;
        }

        .modal-header {
            background: #f3f4f5;
            border-bottom: 1px solid #dcdfe1;
            border-top-right-radius: .3rem;
            border-top-left-radius: .3rem;
        }

        .modal-footer {
            background: #f3f4f5;
            border-top: 1px solid #dcdfe1;
            border-bottom-right-radius: .3rem;
            border-bottom-left-radius: .3rem;
        }

        label {
            font-weight: 400;
        }

        .form-control {
            border-radius: 3px;
        }

        @media (max-width: 767px) {
            .dropdown-menu>li>a {
                padding: 10px 20px !important;
            }

            .skin-blue .main-header .navbar .dropdown-menu li a {
                color: #777;
            }

            .skin-blue .main-header .navbar .dropdown-menu li a:hover {
                background-color: #e1e3e9 !important;
                color: #333 !important;
            }
        }
    </style>
</head>

<body class="hold-transition skin-blue">
    <div class="wrapper">
        <header class="main-header">
            <a href="<?= site_url() ?>" class="logo">
                <span class="logo-lg"><img src="<?= logoDashboard() ?>" alt="" srcset=""></span>
            </a>
            <?php $this->load->view('layout/header') ?>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?= user_photo() ?>" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?= user_profile() ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <?php $this->load->view("layout/sidebar"); ?>
            </section>
        </aside>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>{title} <small>{small}</small></h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    {links}
                </ol>
            </section>
            <section class="content">
                <div class="row">{content}</div>
            </section>
        </div>
        <?php $this->load->view('layout/footer') ?>
    </div>
</body>

</html>