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
</head>
<body>
    <div id="wrapper">
        <?php $this->load->view('member/header'); ?>
        <?php $this->load->view('member/menu'); ?>

        <section class="section littlepad">
            <div class="container">
                <div class="section-title text-center">
                    <h4>Purchase</h4>
                    <h2>My Purchase History</h2>
                </div>
                
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
            // table = $('#tablePurchase').DataTable({
            //     scrollX : true,
            //     searching : false,
            //     processing : true,
            //     language : { processing : 'Loading...' },
            //     serverSide : true,
            //     ajax : {
            //         type    : 'post',
            //         url     : '<?=base_url('member/purchase/history');?>',
            //         dataSrc : function(datatable) { console.log(datatable);
            //             let returnData = new Array();
                        
            //             if(datatable.data.length > 0) {
            //                 for(let i=0; i<datatable.data.length; i++) {
            //                 returnData.push({
            //                     'tanggal_transaksi' : datatable.data[i].tanggal_transaksi
            //                 });
            //             }
            //             }
                        
                        
            //             return returnData;
            //         },
            //         error: function(e) {console.log(e.responseText);}
            //     },
            //     column : [
            //         { data: 'tanggal_transaksi', title: 'Date' },
            //     ]
            // });

            table = $('#tablePurchase').DataTable({
                scrollX : true,
                ordering : false,
                searching : false,
                processing : true,
                language : { processing : 'Loading...' },
                serverSide : true,
                ajax : {
                    type    : 'post',
                    url     : '<?=base_url('member/purchase/history');?>',
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
                    error : function(e) { console.log(e.responseText);
                        // window.location = "<?=base_url('admin/login');?>";
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
                    { targets : 2, render : function(data, type, row) {
                            return '' +
                            '<div class="row flex-row">' +
                                '<div class="col-12 col-sm-6 col-md-4">' +
                                    data +
                                '</div>' +
                                '<div class="col-12 col-sm-6 col-md-8">' +
                                    row.deskripsi_singkat +
                                '</div>' +
                            '</div>';
                        } 
                    }
                ],
            });
        });
    </script>
</body>
</html>