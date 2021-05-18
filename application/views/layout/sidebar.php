<?= $urls = $this->uri->segment(1) ?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="<?= $urls == null || $urls == 'welcome' ? 'active' : null ?>">
        <a href="<?= site_url('welcome') ?>">
            <i class="icon icon-home4"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="treeview <?= $urls == 'pengguna' || $urls == 'supplier' || $urls == 'gudang' ? 'active' : null ?>">
        <a href="#">
            <i class="fas fa-th-large"></i> <span>Master Data</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?= $urls == 'pengguna' ? 'active' : null ?>">
                <a href="<?= site_url('pengguna') ?>"><i class="fa fa-angle-double-right"></i> Pengguna</a>
            </li>
            <li class="<?= $urls == 'supplier' ? 'active' : null ?>">
                <a href="<?= site_url('supplier') ?>"><i class="fa fa-angle-double-right"></i> Supplier</a>
            </li>
            <li class="<?= $urls == 'gudang' ? 'active' : null ?>">
                <a href="<?= site_url('gudang') ?>"><i class="fa fa-angle-double-right"></i> Gudang</a>
            </li>
        </ul>
    </li>
    <li class="treeview <?= $urls == 'satuan' || $urls == 'kategori' || $urls == 'barang' || $urls == 'harga' ? 'active' : null ?>">
        <a href="#">
            <i class="fas fa-boxes"></i> <span>Katalog</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?= $urls == 'satuan' ? 'active' : null ?>">
                <a href="<?= site_url('satuan') ?>"><i class="fa fa-angle-double-right"></i> Satuan</a>
            </li>
            <li class="<?= $urls == 'kategori' ? 'active' : null ?>">
                <a href="<?= site_url('kategori') ?>"><i class="fa fa-angle-double-right"></i> Kategori</a>
            </li>
            <li class="<?= $urls == 'barang' ? 'active' : null ?>">
                <a href="<?= site_url('barang') ?>"><i class="fa fa-angle-double-right"></i> Barang</a>
            </li>
            <li class="<?= $urls == 'harga' ? 'active' : null ?>">
                <a href="<?= site_url('harga') ?>"><i class="fa fa-angle-double-right"></i> Harga Jual</a>
            </li>
        </ul>
    </li>
    <li class="treeview <?= $urls == 'permintaan' || $urls == 'penerimaan' ? 'active' : null ?>">
        <a href="#">
            <i class="fas fa-shopping-basket"></i> <span>Pembelian</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?= $urls == 'permintaan' ? 'active' : null ?>">
                <a href="<?= site_url('permintaan') ?>"><i class="fa fa-angle-double-right"></i> Permintaan</a>
            </li>
            <li class="<?= $urls == 'penerimaan' ? 'active' : null ?>">
                <a href="<?= site_url('penerimaan') ?>"><i class="fa fa-angle-double-right"></i> Penerimaan</a>
            </li>
        </ul>
    </li>
    <li class="treeview <?= $urls == 'roles' ? 'active' : null ?>">
        <a href="#">
            <i class="fas fa-cog"></i> <span>Pengaturan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?= $urls == 'roles' ? 'active' : null ?>">
                <a href="<?= site_url('roles') ?>"><i class="fa fa-angle-double-right"></i> Hak Akses</a>
            </li>
        </ul>
    </li>
</ul>