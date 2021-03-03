<nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?= user_photo() ?>" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?= user_profile() ?></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
                        <img src="<?= user_photo() ?>" class="img-circle" alt="User Image">
                        <p><?= user_profile() ?> <small><?= role_user() ?></small></p>
                    </li>
                    <li>
                        <a href="<?= site_url('profile') ?>" class="profile-item"><i class="dropdown-icon icon-user"></i> Profile Saya</a>
                    </li>
                    <li>
                        <a href="<?= site_url('logout') ?>" class="profile-item"><i class="dropdown-icon icon-switch"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>