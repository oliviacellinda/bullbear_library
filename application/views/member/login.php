<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
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
        .divider {
            width: 100%;
            margin: .7em auto;
            overflow: hidden;
            text-align: center;
        }
        .divider:before, .divider:after {
            content: '';
            display: inline-block;
            border-bottom: 1px solid #131313;
            vertical-align: middle;
            width: 50%;
            margin: 0 .5em 0 -50%;
        }
        .divider:after {
            margin: 0 -50% 0 .5em;
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
                        <h5 class="mb-1">Login</h5>
                        <p>Sign in to continue.</p>
                        <form autocomplete="off">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg rounded-0" name="username_member" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg rounded-0" name="password_member" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <button id="btnLogin" class="btn btn-block btn-primary btn-lg rounded-0">SIGN IN</button>
                            </div>
                        </form>
                        <h6 class="divider">OR</h6>
                        <a href="<?=base_url('member/register');?>">
                            <button class="btn btn-block btn-success btn-lg rounded-0">SIGN UP</button>
                        </a>
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
                $(this).removeClass('has-error');
                if(event.keyCode === 13) {
                    event.preventDefault();
                    $('input[name="password_member"]').focus();
                }
            });

            $('input[name="password_member"]').keypress(function(event) {
                $(this).removeClass('has-error');
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
                            if(response == 'username not found' || response == 'password is wrong') {
                                $('.help-block').remove();
                                $('form').append('<span class="help-block" style="color:#a94442">Username or password is wrong!</span>');
                                $('input[name="username_member"]').focus();
                                $('#btnLogin').html('SIGN IN');
                                $('#btnLogin').removeClass('disabled');
                            }
                            else if(response == 'success') {
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