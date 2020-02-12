<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase History</title>
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/bootstrap.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/all.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/style.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/responsive.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/micrology-master/css/colors.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/datatable/DataTables-1.10.20/css/dataTables.bootstrap4.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/lds-ellipsis.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/custom.css');?>">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .detail-image {
            max-width: 100%;
            display: inline-block;
        }
        .detail-title {
            max-width: 100%;
            display: inline-block;
        }
        @media (min-width: 992px) {
            .detail-image {
                max-width: 33.333333%;
            }
            .detail-title {
                max-width: 66.666666%;
                padding-left: 10px;
                vertical-align: top;
            }
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <?php $this->load->view('member/header'); ?>

        <section class="section">
            <div class="container">
                <div class="section-title text-center">
                    <h4>Purchase</h4>
                    <h2>My Purchase History</h2>
                </div>

                <?php if($this->session->flashdata('alert_status')) : ?>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-<?=$this->session->flashdata('alert_status');?>" role="alert">
                                <?=$this->session->flashdata('alert_info');?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tablePurchase" class="table table-bordered" width="100%">
                            
                            </table>
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
    <script src="<?=base_url('assets/datatable/DataTables-1.10.20/js/jquery.dataTables.min.js');?>"></script>
    <script src="<?=base_url('assets/datatable/DataTables-1.10.20/js/dataTables.bootstrap4.min.js');?>"></script>
    <script src="<?=base_url('assets/moment/min/moment-with-locales.min.js');?>"></script>
    <script src="<?=base_url('assets/js/function.js');?>"></script>
    <script src="<?=base_url('assets/js/data.js');?>"></script>

    <script>
        var table;

        $(document).ready(function() {
            table = $('#tablePurchase').DataTable({
                scrollX : true,
                ordering : false,
                searching : false,
                processing : true,
                language : { processing : 'Loading...' },
                serverSide : true,
                ajax : {
                    type    : 'post',
                    url     : '<?=base_url('member/history/list');?>',
                    dataSrc : function(datatable) {
                        let returnData = new Array();
                        for(let i=0; i<datatable.data.length; i++) {
                            returnData.push({
                                'tanggal_transaksi' : datatable.data[i].tanggal_transaksi,
                                'jenis_paket'       : datatable.data[i].jenis_paket,
                                'total_pembelian'   : datatable.data[i].total_pembelian,
                                'status_verifikasi' : datatable.data[i].status_verifikasi,
                                'nama_paket'        : datatable.data[i].nama_paket,
                                'deskripsi_singkat' : datatable.data[i].deskripsi_singkat,
                                'thumbnail_paket'   : datatable.data[i].thumbnail_paket,
                            });
                        }
                        return returnData;
                    },
                    error : function(e) {
                        window.location = "<?=base_url('member/login');?>";
                    }
                },
                columns : [
                    { data : 'tanggal_transaksi', title : 'Date' },
                    { data : 'jenis_paket', title : 'Category' },
                    { data : 'nama_paket', title : 'Detail' },
                    { data : 'total_pembelian', title : 'Price' },
                    { data : 'status_verifikasi', title : 'Status' },
                ],
                columnDefs : [
                    { targets : 0, width : '130px', render : function(data, type, row) {
                            if(moment(data).isValid()) {
                                let date = moment(data, 'YYYY-MM-DD HH:mm:ss', 'id').format('D MMMM YYYY, ');
                                let time = moment(data, 'YYYY-MM-DD HH:mm:ss', 'id').format('HH:mm');
                                return '<span style="white-space: nowrap;">' + date + '</span>\n' + time;
                            }
                            else
                                return "-";
                        } 
                    },
                    { targets : 2, render : function(data, type, row) {
                            let src = '<?=base_url('course/')?>' + row.jenis_paket + '/thumbnail/' + row.thumbnail_paket;
                            return '' +
                            '<div class="detail-image">' +
                                '<img src="'+src+'" style="width: 100%;">' +
                            '</div>' +
                            '<div class="detail-title">' +
                                '<p style="margin: 0"><strong>' + row.nama_paket + '</strong></p>' +
                                row.deskripsi_singkat
                            '</div>';
                        } 
                    },
                    { targets : 3, render : function(data, type, row) {
                            return currency.format(data);
                        } 
                    },
                    { targets : [1, 4], render : function(data, type, row) {
                            return data.charAt(0).toUpperCase() + data.slice(1);
                        } 
                    },
                ],
            });
        });
    </script>
</body>
</html>