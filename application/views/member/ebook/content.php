<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ebook Content</title>
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/all.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/style.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/responsive.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/colors.css');?>">
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
                            <img src="<?=base_url('course/ebook/thumbnail/' . $ebook['thumbnail_paket']);?>" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-12 col-sm-7 col-md-8 mt-3 mt-sm-0">
                        <h4><?=$ebook['nama_paket'];?></h4>
                        <div style="white-space: pre-line;"><?=$ebook['deskripsi_paket'];?></div>
                        <?php if(!$is_owner) : ?>
                            <h5 class="mt-4"><?='Rp '.number_format($ebook['harga_paket'], 2, ',', '.');?></h5>
                            <div class="mt-3">
                                <button id="btnGateway" class="btn btn-primary">Buy and pay with Midtrans</button>
                                <a href="<?=$ebook['link_ebook'];?>" target="_blank" rel="noopener noreferrer">
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
                    <div class="row justify-content-sm-center">
                        <?php if($content != '') : ?>
                            <div class="col-12 col-md-8 text-center">
                                <table class="table table-bordered">
                                    <tbody>
                                        <?php for($i=0; $i<count($content); $i++) : ?>
                                            <tr>
                                                <td ><?=$i+1;?></td>
                                                <td class="text-left"><?=$content[$i]['nama_ebook'];?></td>
                                                <td>
                                                    <button class="btn btn-success btn-read" style="font-size: inherit;" data-id="<?=$content[$i]['id_ebook'];?>">
                                                        Read
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
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
                            <div class="col-12 col-md-8 text-center">
                                <table class="table table-bordered">
                                    <tbody>
                                        <?php for($i=0; $i<count($content); $i++) : ?>
                                            <tr>
                                                <td><?=$i+1;?></td>
                                                <td class="text-left"><?=$content[$i]['nama_ebook'];?></td>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
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

    </div>

    <div class="dmtop"><i class="fa fa-long-arrow-up"></i></div>

    <script src="<?=base_url('assets/micrology-master/js/jquery.min.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/all.js');?>"></script>
    <script src="<?=base_url('assets/micrology-master/js/custom.js');?>"></script>
    <script src="<?=base_url('assets/js/function.js');?>"></script>
    <script src="<?=base_url('assets/js/data.js');?>"></script>

    <?php if($is_owner) : ?>
        <script>
            $('.btn-read').click(function() {
                let id = $(this).data('id');
                
            });

        </script>
    <?php endif;?>

    <script>
        $('#btnGateway').click(function() {
            $.ajax({
                type    : 'get',
                url     : '<?=base_url('member/ebook/buy/'.$ebook['id_ebook_paket']);?>',
                dataType: 'json',
                beforeSend: function() {

                },
                success : function(response) {
                    showAlert(response);
                },
                error   : function(response) {
                    console.log(response.responseText);
                    toastr.error('Gagal melakukan proses pembayaran.', 'Error!');
                }
            });
        });
    </script>
</body>
</html>