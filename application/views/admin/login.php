<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Login</title>
    <link rel="stylesheet" href="<?=base_url('assets/AdminLTE-2.4.8/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/AdminLTE-2.4.8/bower_components/font-awesome/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/AdminLTE-2.4.8/dist/css/AdminLTE.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/Source_Sans_Pro/font.css');?>">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <p>Bull Bear <small>Admin</small></p>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Sign In</p>
            <form autocomplete="off">
                <div class="form-group has-feedback" id="username">
                    <input type="text" class="form-control" name="username_admin" placeholder="Username" required>
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback" id="password">
                    <input type="password" class="form-control" name="password_admin" placeholder="Password" required>
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <button id="btnLogin" class="btn btn-primary btn-block btn-flat">Masuk</button>
            </form>
        </div>
    </div>

    <script src="<?=base_url('assets/AdminLTE-2.4.8/bower_components/jquery/dist/jquery.min.js');?>"></script>
    <script src="<?=base_url('assets/AdminLTE-2.4.8/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/AdminLTE-2.4.8/dist/js/adminlte.min.js');?>"></script>

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
                $('#btnLogin').html('<i class="fa fa-refresh fa-spin"></i>');
                $('#btnLogin').addClass('disabled');

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
                                $('#btnLogin').html('Masuk');
                                $('#btnLogin').removeClass('disabled');
                            }
                            else if(response == 'berhasil') {
                                window.location = '<?=base_url('admin/dashboard')?>';
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