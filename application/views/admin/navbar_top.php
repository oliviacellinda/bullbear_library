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
                <a href="#" class="nav-link" data-toggle="modal" data-target="#modalPassword">
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

<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="modalPassword" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="password_lama">Password Lama</label>
                    <input type="password" class="form-control" id="password_lama" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="password_baru">Password Baru</label>
                    <input type="password" class="form-control" id="password_baru" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="konfirmasi_password" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-info" id="btnSimpanPasswordAdmin">Simpan</button>
            </div>
        </div>
    </div>
</div>

