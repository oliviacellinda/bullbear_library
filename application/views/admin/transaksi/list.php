<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manajemen Transaksi - Admin</title>
    <link rel="stylesheet" href="<?=base_url('assets/PurpleAdmin/vendors/mdi/css/materialdesignicons.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/PurpleAdmin/vendors/css/vendor.bundle.base.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/PurpleAdmin/css/style.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/datatable/DataTables-1.10.20/css/dataTables.bootstrap4.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/toastr/toastr.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/style.css');?>">
</head>
<body>
    
    <div class="container-scroller">

        <?php $this->load->view('admin/navbar_top');?>

        <div class="container-fluid page-body-wrapper">

            <?php $this->load->view('admin/navbar_left');?>

            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="page-header">
                        <h3 class="page-title"> Manajemen Transaksi </h3>
                    </div>

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <table id="tabelTransaksi" class="table" width="100%" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Menu</th>
                                                <th>Tanggal Transaksi</th>
                                                <th>No. Invoice</th>
                                                <th>Username</th>
                                                <th>Total Pembelian</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?php $this->load->view('admin/footer');?>
            </div>

        </div>

    </div>

    <script src="<?=base_url('assets/PurpleAdmin/vendors/js/vendor.bundle.base.js');?>"></script>
    <script src="<?=base_url('assets/PurpleAdmin/js/off-canvas.js');?>"></script>
    <script src="<?=base_url('assets/PurpleAdmin/js/hoverable-collapse.js');?>"></script>
    <script src="<?=base_url('assets/PurpleAdmin/js/misc.js');?>"></script>
    <script src="<?=base_url('assets/datatable/DataTables-1.10.20/js/jquery.dataTables.min.js');?>"></script>
    <script src="<?=base_url('assets/datatable/DataTables-1.10.20/js/dataTables.bootstrap4.min.js');?>"></script>
    <script src="<?=base_url('assets/toastr/toastr.min.js');?>"></script>
    <script src="<?=base_url('assets/moment/min/moment-with-locales.min.js');?>"></script>
    <script src="<?=base_url('assets/js/function.js');?>"></script>

    <script>
        var tabel;

        $(document).ready(function() {
            tabel = $('#tabelTransaksi').DataTable({
                scrollX : true,
                order : [ [1,'asc'] ],
                searching : false,
                processing : true,
                language : { processing : 'Loading...' },
                serverSide : true,
                ajax : {
                    type    : 'post',
                    url     : '<?=base_url('admin/transaksi/list');?>',
                    dataSrc : function(datatable) {
                        let returnData = new Array();
                        for(let i=0; i<datatable.data.length; i++) {
                            returnData.push({
                                'menu'              : datatable.data[i].invoice,
                                'tanggal_transaksi' : datatable.data[i].tanggal_transaksi,
                                'invoice'           : datatable.data[i].invoice,
                                'username_anggota'  : datatable.data[i].username_anggota,
                                'total_pembelian'   : datatable.data[i].total_pembelian,
                                'status_verifikasi' : datatable.data[i].status_verifikasi,
                            });
                        }
                        return returnData;
                    },
                    error : function(e) { console.log(e.responseText);
                        // window.location = "<?=base_url('admin/login');?>";
                    }
                },
                columns : [
                    { data : 'menu', orderable : false },
                    { data : 'tanggal_transaksi' },
                    { data : 'invoice' },
                    { data : 'username_anggota' },
                    { data : 'total_pembelian' },
                    { data : 'status_verifikasi' },
                ],
                columnDefs : [
                    { targets : 0, render : function(data, type, row) {
                            return '<button id="btnVerifikasi" class="btn btn-sm btn-info mr-1">' +
                                '<i class="mdi mdi-check"></i>' +
                            '</button>' +
                            '<button id="btnDetail" class="btn btn-sm btn-primary">' +
                                '<i class="mdi mdi-information"></i>' +
                            '</button>';
                        } 
                    },
                    { targets : 4, render : $.fn.dataTable.render.number('.', ',', 2, 'Rp ') },
                    { targets : 1, render : function(data, type, row) {
                            if(moment(data).isValid())
                                return moment(data, 'YYYY-MM-DD HH:mm:ss', 'id').format('D MMMM YYYY, HH:mm');
                            else
                                return "-";
                        } 
                    },
                ],
            });

        });
    </script>
</body>
</html>