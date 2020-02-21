<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Login</title>
    <link rel="stylesheet" href="<?=base_url('assets/PurpleAdmin/vendors/mdi/css/materialdesignicons.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/PurpleAdmin/vendors/css/vendor.bundle.base.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/PurpleAdmin/css/style.css');?>">
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="<?=base_url('assets/images/logo.png');?>">
                            </div>
                            <h4>Login</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" name="username_admin" placeholder="Username" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" name="password_admin" placeholder="Password" autocomplete="off">
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
      <!-- page-body-wrapper ends -->
    </div>

    <script src="<?=base_url('assets/PurpleAdmin/vendors/js/vendor.bundle.base.js');?>"></script>
    <script src="<?=base_url('assets/PurpleAdmin/js/off-canvas.js');?>"></script>
    <script src="<?=base_url('assets/PurpleAdmin/js/hoverable-collapse.js');?>"></script>
    <script src="<?=base_url('assets/PurpleAdmin/js/misc.js');?>"></script>

    <script>
        $(document).ready(function() {
            $('input[name="username_admin"]').focus();

            $('input[name="username_admin"]').keypress(function(event) {
                $('#username').removeClass('has-error');
                if(event.keyCode === 13) {
                    event.preventDefault();
                    $('input[name="password_admin"]').focus();
                }
            });

            $('input[name="password_admin"]').keypress(function(event) {
                $('#password').removeClass('has-error');
            });

            $('form').submit(function(event) {
                event.preventDefault();
                $('.btn').addClass('disabled');

                let username = $('input[name="username_admin"]').val();
                let password = $('input[name="password_admin"]').val();

                if(username != '' && password != '') {
                    $.ajax({
                        type    : 'post',
                        url     : '<?=base_url('admin/prosesLogin');?>',
                        dataType: 'json',
                        data    : {
                            username : username,
                            password : password
                        },
                        success : function(response) {
                            if(response == 'username tidak ada' || response == 'password salah') {
                                $('.help-block').remove();
                                $('form').append('<span class="help-block" style="color:#a94442">Username atau password Anda salah!</span>');
                                $('#username').addClass('has-error');
                                $('#password').addClass('has-error');
                                $('input[name="username_admin"]').focus();
                                $('.btn').removeClass('disabled');
                            }
                            else if(response == 'berhasil') {
                                window.location = '<?=base_url('admin/user')?>';
                            }
                        },
                        error   : function(response) {
                            console.log(response.responseText);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>