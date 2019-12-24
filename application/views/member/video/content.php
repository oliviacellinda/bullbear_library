<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Video Content</title>
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/all.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/style.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/responsive.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/colors.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/video.js/dist/video-js.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/lds-ellipsis.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/custom.css');?>">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="wrapper">
        <?php $this->load->view('member/header'); ?>

        <section class="section first-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-5 col-md-4">
                        <div class="screen-normal wow slideInLeft">
                            <img src="<?=base_url('course/video/thumbnail/' . $video['thumbnail_paket']);?>" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-12 col-sm-7 col-md-8 mt-3 mt-sm-0">
                        <h4><?=$video['nama_paket'];?></h4>
                        <div><?=$video['deskripsi_paket'];?></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section bt">
            <div class="container">
                <div class="section-title text-center">
                    <h2>Content</h2>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4" style="overflow-y: scroll;">
                        <ul class="list-group">
                            <?php for($i=0; $i<count($content); $i++) : ?>
                                <li class="list-group-item"><?=$content[$i]['nama_video'];?></li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                    <div class="col-12 col-md-8">
                        <!-- <video
                            id="player"
                            class="video-js"
                            controls
                            preload="none"
                            width="600"
                            data-setup="{}" >

                            <source type="video/mp4" src="<?=base_url('course/video/content/1/animegrimoire_Karakai_Jouzu_no_Takagi-san_-_02_720p1C16FDD0.mp4');?>">

                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                        </video> -->
                        <video id="player"></video>
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
    <script src="<?=base_url('assets/video.js/dist/video.min.js');?>"></script>
    <script src="<?=base_url('assets/js/function.js');?>"></script>
    <script src="<?=base_url('assets/js/data.js');?>"></script>

    <script>
        // var player = videojs('');

        function loadVideo($id) {

        }

    </script>
</body>
</html>