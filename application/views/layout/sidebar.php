<?= $urls = $this->uri->segment(1) ?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="<?= $urls == null || $urls == 'welcome' ? 'active' : null ?>">
        <a href="<?= site_url('welcome') ?>">
            <i class="icon-home4"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="treeview <?= $urls == 'satuan' ? 'active' : null ?>">
        <a href="#">
            <i class="icon-color-sampler"></i> <span>Master Data</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="#"><i class="fa fa-angle-double-right"></i> Pengguna</a>
            </li>
              <li class="<?= $urls == 'satuan' ? 'active' : null ?>">

                <a href="<?= site_url('satuan') ?>"><i class="fa fa-angle-double-right"></i> Satuan</a>
            </li>
              </li>
              <li class="<?= $urls == 'gudang' ? 'active' : null ?>">

                <a href="<?= site_url('gudang') ?>"><i class="fa fa-angle-double-right"></i> Gudang</a>
            </li>
        </ul>
    </li>
</ul>