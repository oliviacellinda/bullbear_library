<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/all.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/style.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/responsive.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/colors.css');?>">
    <style>
        .login-page {
            background-color: #d1e8f9;
            width: 100%;
            min-height: 100vh;
            padding-left: 0;
            padding-right: 0;
            display: flex;
            flex-direction: row;
        }
        .login-form {
            background-color: white;
        }
        input {
            font-size: 1rem !important;
        }
        .form-control::placeholder {
            color: #999999 !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid login-page">
        <div class="d-flex w-100 align-items-center p-5">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto">
                    <div class="login-form p-5">
                        <div class="mb-5">
                            <img src="<?=base_url('assets/images/logo.png');?>" width="150px">
                        </div>
                        <h5 class="mb-1">Register</h5>
                        <p>Sign up as new member.</p>
                        <form autocomplete="off">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg rounded-0" name="username_member" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg rounded-0" name="password_member" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg rounded-0" name="email_member" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg rounded-0" name="nama_member" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-block btn-primary btn-lg rounded-0">SIGN UP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?=base_url('assets/micrology-master/js/jquery.min.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/all.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/custom.js');?>"></script>

    <script>
        $(document).ready(function() {
            $('input[name="username_member"]').focus();

            $('input[name="username_member"]').keypress(function(event) {
                $('#username').removeClass('has-error');
            });

            $('input[name="password_member"]').keypress(function(event) {
                $('#password').removeClass('has-error');
            });

            $('form').submit(function(event) {
                event.preventDefault();
                $('#btnLogin').html('<i class="fa fa-refresh fa-spin"></i>');
                $('#btnLogin').addClass('disabled');

                let username = $('input[name="username_member"]').val();
                let password = $('input[name="password_member"]').val();

                if(username != '' && password != '') {
                    $.ajax({
                        type    : 'post',
                        url     : '<?=base_url('member/prosesLogin');?>',
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
                                $('input[name="username_member"]').focus();
                                $('#btnLogin').html('Masuk');
                                $('#btnLogin').removeClass('disabled');
                            }
                            else if(response == 'berhasil') {
                                window.location = '<?=base_url('member/home')?>';
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