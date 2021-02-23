<?= $urls = $this->uri->segment(1) ?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="<?= $urls == null || $urls == 'welcome' ? 'active' : null ?>">
        <a href="<?= site_url('welcome') ?>">
            <i class="icon-home4"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="icon-color-sampler"></i> <span>Master Data</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="#"><i class="fa fa-angle-double-right"></i> Penggunaa</a>
            </li>

            <li>
                <a href="<?= site_url('sup') ?>"><i class="fa fa-angle-double-right"></i> Supplier</a>
            </li>
        </ul>
    </li>
</ul>