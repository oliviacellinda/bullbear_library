<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a href="<?=base_url('admin/login');?>" class="navbar-brand brand-logo"><img src="<?=base_url('assets/images/logo.png');?>" alt="logo"></a>
        <a href="<?=base_url('admin/login');?>" class="navbar-brand brand-logo-mini"><img src="<?=base_url('assets/images/logo-mini.png');?>" alt="logo"></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items stretch">
        <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-logout d-lg-block">
                <a href="<?=base_url('admin/password');?>" class="nav-link">
                    <i class="mdi mdi-lock-reset"></i>
                </a>
            </li>
            <li class="nav-item nav-logout d-lg-block">
                <a href="<?=base_url('admin/logout');?>" class="nav-link">
                    <i class="mdi mdi-power"></i>
                </a>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        	<span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
