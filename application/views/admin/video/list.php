<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manajemen Video - Admin</title>
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
                        <h3 class="page-title"> Manajemen Video </h3>
                    </div>

                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-12">
                            <a href="<?=base_url('admin/video/tambah');?>" class="btn btn-info btn-icon-text">
                                <i class="mdi mdi-plus btn-icon-prepend"></i>
                                Tambah paket
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <table id="tabelVideo" class="table" width="100%" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Menu</th>
                                                <th>Nama Paket Video</th>
                                                <th>Harga</th>
                                                <th>Tanggal Dibuat</th>
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

    <div id="modalEdit" class="modal fade" tabindex="-1" role="dialog">
    
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
            tabel = $('#tabelVideo').DataTable({
                scrollX : true,
                order : [ [1,'asc'] ],
                searching : false,
                processing : true,
                language : { processing : 'Loading...' },
                serverSide : true,
                ajax : {
                    type    : 'post',
                    url     : '<?=base_url('admin/video/list');?>',
                    dataSrc : function(datatable) {
                        let returnData = new Array();
                        for(let i=0; i<datatable.data.length; i++) {
                            returnData.push({
                                'menu'          : datatable.data[i].id_video_paket,
                                'nama_paket'    : datatable.data[i].nama_paket,
                                'harga_paket'   : datatable.data[i].harga_paket,
                                'tanggal_dibuat': datatable.data[i].tanggal_dibuat,
                            });
                        }
                        return returnData;
                    },
                    error : function() {
                        window.location = "<?=base_url('admin/login');?>";
                    }
                },
                columns : [
                    { data : 'menu', orderable : false },
                    { data : 'nama_paket' },
                    { data : 'harga_paket' },
                    { data : 'tanggal_dibuat' },
                ],
                columnDefs : [
                    { targets : 0, render : function(data, type, row) {
                            return '<button id="btnEdit" class="btn btn-sm btn-success mr-1">'+
                                '<i class="mdi mdi-pencil"></i>' +
                            '</button>' +
                            '<a href="<?=base_url('admin/video/detail/');?>'+data+'" id="btnDetail" class="btn btn-sm btn-primary mr-1">'+
                                '<i class="mdi mdi-information"></i>' +
                            '</a>' +
                            '<button id="btnHapus" class="btn btn-sm btn-danger">'+
                                '<i class="mdi mdi-delete"></i>' +
                            '</button>'
                        } 
                    },
                    { targets : 2, render : $.fn.dataTable.render.number('.', ',', 2, 'Rp ') },
                    { targets : 3, render : function(data, type, row) {
                            if(moment(data).isValid())
                                return moment(data, 'YYYY-MM-DD HH:mm:ss', 'id').format('D MMMM YYYY, HH:mm');
                            else
                                return "-";
                        } 
                    },
                ],
            });

            $('#tabelVideo').on('click', '#btnHapus', function() {
                if( confirm('Apakah Anda yakin ingin menghapus paket video ini?') ) {
                    let tr = $(this).parents('tr');
                    let row = tabel.row(tr).data();
                    let id = row.menu;

                    $.ajax({
                        type    : 'post',
                        url     : '<?=base_url('admin/video/hapus');?>',
                        dataType: 'json',
                        data    : { id : id },
                        beforeSend: function() {
                            loading('.card');
                        },
                        success : function(response) {
                            showAlert(response);
                        },
                        error   : function(e) {
                            toastr.error('Gagal menghapus data.', 'Error!');
                        },
                        complete: function() {
                            tabel.ajax.reload(null, false);
                            removeLoading('.card');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>