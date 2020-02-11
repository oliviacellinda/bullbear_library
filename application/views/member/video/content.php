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
    <link rel="stylesheet" href="<?=base_url('assets/video.js/themes/fantasy/index.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/toastr/toastr.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/lds-ellipsis.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/custom.css');?>">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .duration::before {
            content: " (";
            white-space: pre;
        }
        .duration::after {
            content: ')';
        }
    </style>
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
                        <div style="white-space: pre-line;"><?=$video['deskripsi_paket'];?></div>
                        <?php if(!$is_owner) : ?>
                            <h5 class="mt-4"><?='Rp '.number_format($video['harga_paket'], 2, ',', '.');?></h5>
                            <div class="mt-3">
                                <button id="btnGateway" class="btn btn-primary">Buy and pay with Midtrans</button>
                                <a href="<?=$video['link_video'];?>" target="_blank" rel="noopener noreferrer">
                                    <button id="btnOutside" class="btn btn-primary mt-1 mt-lg-0">Buy from Tokopedia(?)</button>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="section littlepad bt">
            <div class="container">
                <div class="section-title text-center">
                    <h2>Content</h2>
                </div>

                <?php if($is_owner) : ?>
                    <div class="row d-none d-md-flex">
                        <?php if($content != '') : ?>
                            <div class="col-12 col-md-4">
                                <ul class="list-group">
                                    <?php for($i=0; $i<count($content); $i++) : ?>
                                        <button class="list-group-item list-group-item-action" style="font-family: inherit;">
                                            <?=$content[$i]['nama_video'];?>
                                            <span class="duration"><?=$content[$i]['durasi_video'];?></span>
                                            <span class="id-video d-none"><?=$content[$i]['id_video'];?></span>
                                            <span class="file-video d-none"><?=$content[$i]['file_video'];?></span>
                                        </button>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        <?php else : ?>
                            <div class="col-12 text-center">
                                <span>No data.</span>
                            </div>
                        <?php endif; ?>
                        <div class="col-12 col-md-8">
                            <video id="player-desktop" class="video-js vjs-fluid vjs-theme-fantasy" oncontextmenu="return false;" controls preload="none" data-setup="{}">
                                <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p>
                            </video>
                        </div>
                    </div>

                    <div class="row d-block d-md-none">
                        <div class="col-12">
                            <video id="player-mobile" class="video-js vjs-fluid vjs-theme-fantasy" oncontextmenu="return false;" controls preload="none" data-setup="{}">
                                <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video</p>
                            </video>
                        </div>
                        <?php if($content != '') : ?>
                            <div class="col-12 mt-3">
                                <ul class="list-group">
                                    <?php for($i=0; $i<count($content); $i++) : ?>
                                        <button class="list-group-item list-group-item-action" style="font-family: inherit;">
                                            <?=$content[$i]['nama_video'];?>
                                            <span class="duration"><?=$content[$i]['durasi_video'];?></span>
                                            <span class="id-video d-none"><?=$content[$i]['id_video'];?></span>
                                            <span class="file-video d-none"><?=$content[$i]['file_video'];?></span>
                                        </button>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        <?php else : ?>
                            <div class="col-12 text-center">
                                <span>No data.</span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="row justify-content-sm-center">
                        <?php if($content != '') : ?>
                            <div class="col-12 col-sm-10 col-md-8 text-center">
                                <ul class="list-group">
                                    <?php for($i=0; $i<count($content); $i++) : ?>
                                        <button class="list-group-item list-group-item-action" style="font-family: inherit;">
                                            <?=$content[$i]['nama_video'];?>
                                            <span class="duration"><?=$content[$i]['durasi_video'];?></span>
                                        </button>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        <?php else : ?>
                            <div class="col-12 text-center">
                                <span>No data.</span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </section>

        <div class="body-overlay">
            <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
        </div>
    </div>

    <div class="dmtop"><i class="fa fa-long-arrow-up"></i></div>

    <script src="<?=base_url('assets/micrology-master/js/jquery.min.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/all.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/custom.js');?>"></script>
    <script src="<?=base_url('assets/video.js/dist/video.min.js');?>"></script>
    <script src="<?=base_url('assets/toastr/toastr.min.js');?>"></script>
    <script src="<?=base_url('assets/js/function.js');?>"></script>
    <script src="<?=base_url('assets/js/data.js');?>"></script>

    <?php if($is_owner) : ?>
        <script>
            var id = <?=$video['id_video_paket'];?>;
            var playerDesktop = videojs('player-desktop');
            var playerMobile = videojs('player-mobile');

            function loadVideo(data) {
                $('.list-group-item').removeClass('active'); console.log(data);
                data.container.addClass('active');
                playerDesktop.src([
                    {type: 'video/mp4', src: base_url.index + 'course/video/content/' + id + '/' + data.video}
                ]);
                playerMobile.src([
                    {type: 'video/mp4', src: base_url.index + 'course/video/content/' + id + '/' + data.video}
                ]);
            }

            $(window).ready(function() {
                let first = new Object();
                first.container = $('.list-group-item:first');
                first.id = $('.list-group-item:first').find('.id-video').text();
                first.video = $('.list-group-item:first').find('.file-video').text();
                loadVideo(first);

                $('.list-group-item').click(function() {
                    let data = new Object();
                    data.container = $(this);
                    data.id = $(this).find('.id-video').text();
                    data.video = $(this).find('.file-video').text();
                    loadVideo(data);
                });
            });

        </script>
    <?php endif;?>

    <script>
        $('#btnGateway').click(function() {
            $.ajax({
                type    : 'post',
                url     : '<?=base_url('member/transaction/new');?>',
                data    : { type : 'video', id : '<?=$video['id_video_paket'];?>' },
                dataType: 'json',
                beforeSend: function() {
                    $('.body-overlay').show();
                },
                success : function(response) {
                    if(response.type == 'success') {
                        window.location = response.redirect_url;
                    }
                    else {
                        showAlert(response);
                    }
                },
                error   : function(response) {
                    console.log(response.responseText);
                    toastr.error('Internal server error.', 'Error!');
                },
                complete : function() {
                    $('.body-overlay').hide();
                }
            });
        });
    </script>
</body>
</html>