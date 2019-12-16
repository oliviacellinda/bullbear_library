<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manajemen User - Admin</title>
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
                        <h3 class="page-title"> Manajemen User </h3>
                    </div>

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <table id="tabelUser" class="table" width="100%" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Edit</th>
                                                <th>Username</th>
                                                <th>Nama</th>
                                                <th>Email</th>
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
    <script src="<?=base_url('assets/js/function.js');?>"></script>

    <script>
        var tabel;

        $(document).ready(function() {
            tabel = $('#tabelUser').DataTable({
                scrollX : true,
                order : [ [1,'asc'] ],
                searching : false,
                processing : true,
                language : { processing : 'Loading...' },
                serverSide : true,
                ajax : {
                    type    : 'post',
                    url     : '<?=base_url('admin/user/list');?>',
                    dataSrc : function(datatable) {
                        if('data' in datatable) {
                            let returnData = new Array();
                            for(let i=0; i<datatable.data.length; i++) {
                                returnData.push({
                                    'edit'             : datatable.data[i].username_member,
                                    'username_member'  : datatable.data[i].username_member,
                                    'nama_member'      : datatable.data[i].nama_member,
                                    'email_member'     : datatable.data[i].email_member,
                                });
                            }
                            return returnData;
                        }
                        else {
                            window.location = "<?=base_url('admin/login');?>";
                        }
                    },
                    error : function() {
                        window.location = "<?=base_url('admin/login');?>";
                    }
                },
                columns : [
                    { data : 'edit', orderable : false },
                    { data : 'username_member' },
                    { data : 'nama_member' },
                    { data : 'email_member' },
                ],
                columnDefs : [
                    { targets : 0, render : function(data, type, row) {
                            return '<button id="btnReset" class="btn btn-sm btn-dark" data-username="'+data+'">'+
                                '<i class="mdi mdi-lock-reset"></i>' +
                            '</button>';
                        } 
                    },
                ],
            });

            $('#tabelUser').on('click', '#btnReset', function() {
                let username = $(this).data('username');
                let element = $('.card');
                $.ajax({
                    type    : 'post',
                    url     : '<?=base_url('admin/user/reset');?>',
                    dataType: 'json',
                    data    : { username : username },
                    beforeSend: function() {
                        loading(element);
                    },
                    success : function(response) {
                        showAlert(response);
                    },
                    error   : function() {
                        toastr.error('Gagal mereset password.', 'Error!');
                    },
                    complete: function() {
                        tabel.ajax.reload(null, false);
                        removeLoading(element);
                    }
                });
            });
        });
    </script>
</body>
</html>