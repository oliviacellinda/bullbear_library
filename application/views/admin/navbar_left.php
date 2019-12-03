<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="<?=base_url('assets/images/user.png');?>" alt="profile">
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">Administrator</span>
                    <span class="text-secondary text-small">Admin Panel</span>
                </div>
            </a>
        </li>
        <li id="navUser" class="nav-item">
            <a href="<?=base_url('admin/user');?>" class="nav-link">
                <span class="menu-title">Manajemen User</span>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
        </li>
        <li id="navVideo" class="nav-item">
            <a href="<?=base_url('admin/video');?>" class="nav-link">
                <span class="menu-title">Manajemen Video</span>
                <i class="mdi mdi-video menu-icon"></i>
            </a>
        </li>
        <li id="navEbook" class="nav-item">
            <a href="<?=base_url('admin/ebook');?>" class="nav-link">
                <span class="menu-title">Manajemen Ebook</span>
                <i class="mdi mdi-book-multiple menu-icon"></i>
            </a>
        </li>
        <li id="navTransaksi" class="nav-item">
            <a href="<?=base_url('admin/transaksi');?>" class="nav-link">
                <span class="menu-title">Manajemen Transaksi</span>
                <i class="mdi mdi-receipt menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
