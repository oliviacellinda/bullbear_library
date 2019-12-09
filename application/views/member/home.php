<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/all.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/style.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/responsive.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/colors.css');?>">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .transparent-header {
            background-color: royalblue !important;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <header class="header transparent-header">
            <div class="container">
                <nav class="navbar navbar-toggleable-md navbar-inverse yamm" id="slide-nav">
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTopMenu" aria-controls="navbarTopMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="<?=base_url('member/home');?>">Bull Bear</a>
                    <div class="collapse navbar-collapse" id="navbarTopMenu">
                        <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                            <li><a class="nav-link" href="<?=base_url('member/my-video');?>">My Videos</a></li>
                            <li><a class="nav-link" href="<?=base_url('member/my-ebook');?>">My E-Books</a></li>
                            <li><a class="nav-link" href="<?=base_url('member/purchase/history');?>">Purchase History</a></li>
                            <li><a class="nav-link" href="<?=base_url('member/change-password');?>">Change Password</a></li>
                            <li><a class="nav-link" href="<?=base_url('member/logout');?>">Log Out</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <section class="section">
            <div class="container">
                <div class="section-title text-center">
                    <h4>Videos</h4>
                    <h2>Our Latest Videos</h2>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="portfolio-ver-01" style="border: 1px solid #e9edf5;">
                            <div class="media-element">
                                <img src="http://localhost/bullbear_library/assets/micrology-master/upload/work_03.jpg" alt="" class="img-fluid">
                            </div>
                            <div class="portfolio-details"> 
                                <h4><a href="#">Web Design Process</a></h4>
                                <p>One of the options of the e-commerce layout for online</p>
                            </div>
                            <div class="portfolio-meta clearfix">
                                <div class="float-left">
                                    <mark>$21.00</mark>
                                </div>
                                <div class="float-right">
                                    <a href="#"><i class="fa fa-folder-open-o"></i> Webdesign</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section lb">
            <div class="container">
                <div class="section-title text-center">
                    <h4>E-Books</h4>
                    <h2>Our Latest E-Books</h2>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="portfolio-ver-01">
                            <div class="media-element">
                                <img src="http://localhost/bullbear_library/assets/micrology-master/upload/work_03.jpg" alt="" class="img-fluid">
                            </div>
                            <div class="portfolio-details"> 
                                <h4><a href="#">Web Design Process</a></h4>
                                <p>One of the options of the e-commerce layout for online</p>
                            </div>
                            <div class="portfolio-meta clearfix">
                                <div class="float-left">
                                    <mark>$21.00</mark>
                                </div>
                                <div class="float-right">
                                    <a href="#"><i class="fa fa-folder-open-o"></i> Webdesign</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <div class="dmtop"><i class="fa fa-long-arrow-up"></i></div>

    <script src="<?=base_url('assets/micrology-master/js/jquery.min.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/all.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/custom.js');?>"></script>

    <script id="portfolio" type="text/html">
        <div class="col-md-4">
            <div class="portfolio-ver-01">
                <div class="media-element">
                    <img src="http://localhost/bullbear_library/assets/micrology-master/upload/work_03.jpg" alt="" class="img-fluid">
                </div>
                <div class="portfolio-details"> 
                    <h4><a href="#">Web Design Process</a></h4>
                    <p>One of the options of the e-commerce layout for online</p>
                </div>
                <div class="portfolio-meta clearfix">
                    <div class="float-left">
                        <mark>$21.00</mark>
                    </div>
                    <div class="float-right">
                        <a href="#"><i class="fa fa-folder-open-o"></i> Webdesign</a>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script>
        $(document).ready(function() {
            console.log($('#portfolio'));
            console.log($('.portfolio-ver-01:first'));
            var temp = $('#portfolio')[0].innerHTML;
            console.log(temp.innerHTML);
            $('.row').append(temp);
        });
    </script>
</body>
</html>