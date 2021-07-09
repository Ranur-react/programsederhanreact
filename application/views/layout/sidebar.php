<?= $urls = $this->uri->segment(1) ?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="<?= $urls == null || $urls == 'welcome' ? 'active' : null ?>">
        <a href="<?= site_url('welcome') ?>">
            <i class="icon icon-home4"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="treeview <?= $urls == 'satuan' || $urls == 'kategori' || $urls == 'barang' || $urls == 'harga' || $urls == 'stok-barang' ? 'active' : null ?>">
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
            <li class="<?= $urls == 'stok-barang' ? 'active' : null ?>">
                <a href="<?= site_url('stok-barang') ?>"><i class="fa fa-angle-double-right"></i> Stok Barang</a>
            </li>
        </ul>
    </li>
    <li class="treeview <?= $urls == 'supplier' || $urls == 'gudang' || $urls == 'permintaan' || $urls == 'penerimaan' || $urls == 'pelunasan' ? 'active' : null ?>">
        <a href="#">
            <i class="fas fa-shopping-basket"></i> <span>Pembelian</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?= $urls == 'supplier' ? 'active' : null ?>">
                <a href="<?= site_url('supplier') ?>"><i class="fa fa-angle-double-right"></i> Supplier</a>
            </li>
            <li class="<?= $urls == 'gudang' ? 'active' : null ?>">
                <a href="<?= site_url('gudang') ?>"><i class="fa fa-angle-double-right"></i> Gudang</a>
            </li>
            <li class="<?= $urls == 'permintaan' ? 'active' : null ?>">
                <a href="<?= site_url('permintaan') ?>"><i class="fa fa-angle-double-right"></i> Permintaan</a>
            </li>
            <li class="<?= $urls == 'penerimaan' || $urls == 'pelunasan' ? 'active' : null ?>">
                <a href="<?= site_url('penerimaan') ?>"><i class="fa fa-angle-double-right"></i> Penerimaan</a>
            </li>
        </ul>
    </li>
    <li class="treeview <?= $urls == 'customer' || $urls == 'pesanan' ? 'active' : null ?>">
        <a href="#">
            <i class="fas fa-shopping-cart"></i> <span>Penjualan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?= $urls == 'customer' ? 'active' : null ?>">
                <a href="<?= site_url('customer') ?>"><i class="fa fa-angle-double-right"></i> Customer</a>
            </li>
            <li class="<?= $urls == 'pesanan' ? 'active' : null ?>">
                <a href="<?= site_url('pesanan') ?>"><i class="fa fa-angle-double-right"></i> Pesanan</a>
            </li>
        </ul>
    </li>
    <li class="<?= $urls == 'pengiriman' ? 'active' : null ?>">
        <a href="<?= site_url('pengiriman') ?>">
            <i class="fas fa-shipping-fast"></i> <span>Pengiriman</span>
        </a>
    </li>
    <li class="treeview <?= $urls == 'pengguna' || $urls == 'roles' || $urls == 'rekening' ? 'active' : null ?>">
        <a href="#">
            <i class="fas fa-cog"></i> <span>Pengaturan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?= $urls == 'pengguna' ? 'active' : null ?>">
                <a href="<?= site_url('pengguna') ?>"><i class="fa fa-angle-double-right"></i> Pengguna</a>
            </li>
            <li class="<?= $urls == 'roles' ? 'active' : null ?>">
                <a href="<?= site_url('roles') ?>"><i class="fa fa-angle-double-right"></i> Hak Akses</a>
            </li>
            <li class="<?= $urls == 'rekening' ? 'active' : null ?>">
                <a href="<?= site_url('rekening') ?>"><i class="fa fa-angle-double-right"></i> Rekening Bank</a>
            </li>
        </ul>
    </li>
</ul>