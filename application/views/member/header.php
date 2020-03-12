<header class="header transparent-header"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div class="container">
        <nav class="navbar navbar-toggleable-md navbar-inverse yamm" id="slide-nav">
            <button class="navbar-toggler navbar-toggler-right" style="z-index: 10;" type="button" data-toggle="collapse" data-target="#navbarTopMenu" aria-controls="navbarTopMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="<?=base_url('member/home');?>">Bull Bear</a>
            <div class="collapse navbar-collapse" id="navbarTopMenu">
                <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                    <li><a class="nav-link" href="<?=base_url('member/my-video');?>">My Videos</a></li>
                    <li><a class="nav-link" href="<?=base_url('member/my-ebook');?>">My E-Books</a></li>
                    <li><a class="nav-link" href="<?=base_url('member/history');?>">Purchase History</a></li>
                    <li><a class="nav-link" href="#" data-toggle="modal" data-target="#modalPassword">Change Password</a></li>
                    <li><a class="nav-link" href="<?=base_url('member/logout');?>">Log Out</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="modalPassword" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="password_lama">Old Password</label>
                    <input type="password" class="form-control" id="password_lama" autocomplete="off">
                    <div class="form-control-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="password_baru">New Password</label>
                    <input type="password" class="form-control" id="password_baru" autocomplete="off">
                    <div class="form-control-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="konfirmasi_password">Confirm New Password</label>
                    <input type="password" class="form-control" id="konfirmasi_password" autocomplete="off">
                    <div class="form-control-feedback"></div>
                </div>
                <div class="loading d-none">
                    <i class="fa fa-spin fa-refresh"></i>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSimpanPasswordMember">Simpan</button>
            </div>
        </div>
    </div>
</div>