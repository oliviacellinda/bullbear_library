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
    <link rel="stylesheet" href="<?=base_url('assets/font-awesome/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/datatable/DataTables-1.10.20/css/dataTables.bootstrap4.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/toastr/toastr.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/lds-ellipsis.css');?>">
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

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Informasi Paket Video</h4>
                                    <div class="row">
                                        <div class="col-md-6 mt-5 separator-line">
                                            <div class="d-flex flex-column align-items-top">
                                                <div class="mb-4 flex-grow">
                                                    <h5 class="mb-2">Nama Paket Video</h5>
                                                    <div class="ml-4 mb-0 font-weight-light">
                                                        <?=$video['nama_paket'];?>
                                                    </div>
                                                </div>
                                                <div class="mb-4 flex-grow">
                                                    <h5 class="mb-2">Deskripsi Paket</h5>
                                                    <div class="ml-4 mb-0 font-weight-light">
                                                        <?=$video['deskripsi_paket'];?>
                                                    </div>
                                                </div>
                                                <div class="mb-4 flex-grow">
                                                    <h5 class="mb-2">Harga Paket</h5>
                                                    <div class="ml-4 mb-0 font-weight-light">
                                                        <?='Rp ' . number_format($video['harga_paket'], 2, ',', '.');?>
                                                    </div>
                                                </div>
                                                <div class="mb-4 flex-grow">
                                                    <h5 class="mb-2">Thumbnail</h5>
                                                    <div class="mb-0">
                                                        <img src="<?=base_url('course/video/thumbnail/'.$video['thumbnail_paket']);?>" alt="Thumbnail" style="width: 100%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-5">
                                                <button class="btn btn-info btn-icon-text" data-toggle="modal" data-target="#modalVideo">
                                                    <i class="mdi mdi-plus btn-icon-prepend"></i>
                                                    Tambah video
                                                </button>
                                                <ul class="mt-3 list-group">
                                                    
                                                </ul>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?php $this->load->view('admin/footer');?>
            </div>

        </div>

    </div>

    <div id="modalVideo" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form id="formVideo" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="judul">Judul Video</label>
                                    <input type="text" id="judul" name="judul" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="upload">Upload Video</label>
                                    <input type="file" accept="video/*" id="upload" name="upload">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-info" id="btnSimpan">Simpan</button>
                </div>
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
    <script src="<?=base_url('assets/bootstrap-filestyle-2.1.0/bootstrap-filestyle.min.js');?>"></script>
    <script src="<?=base_url('assets/js/function.js');?>"></script>

    <script>
        function loadVideo() {
            $.ajax({
                type    : 'post',
                url     : '<?=base_url('admin/video/isi/'.$video['id_video_paket']);?>',
                dataType: 'json',
                beforeSend: function() {
                    showEllipsis('.list-group');
                },
                success : function(data) {
                    $('.ellipsis').remove();

                    if(data != null && data.length != 0) {
                        let li = '';
                        for(let i=0; i<data.length; i++) {
                            li += '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                                data[i].nama_video +
                                '<span class="btn-icon-only badge badge-danger badge-pill" data-id="'+data[i].id_video+'">' +
                                    '<i class="fa fa-times"></i>'
                                '</span>' +
                            '</li>';
                        }
                        $('.list-group').html(li);
                    }
                    else {
                        $('.list-group').html('<span>Tidak ada data.</span>');
                    }
                },
            });
        }

        $(document).ready(function() {
            $('#navVideo').addClass('active');
            $(':file').filestyle({
                dragdrop : false,
                text : 'Upload video',
                btnClass : 'btn-info btn-file',
                buttonBefore : true,
            });

            loadVideo();

            $('#btnSimpan').click(function(event) {
                event.preventDefault();
                let id = window.location.href.split('/');
                id = id[id.length - 1];
                let formData = new FormData();
                formData.append('id', id);
                formData.append('judul', $('#judul').val().trim());
                formData.append('video', $('#upload')[0].files[0]);
                
                $.ajax({
                    type    : 'post',
                    url     : '<?=base_url('admin/video/isi/tambah');?>',
                    dataType: 'json',
                    data    : formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        loading('.modal-body');
                        $('.modal-footer button').prop('disabled', true);
                    },
                    success : function(data) {
                        showAlert(data);
                    },
                    error   : function(e) {
                        toastr.error('Gagal menyimpan data.', 'Error!');
                    },
                    complete: function() {
                        $('#formVideo').trigger('reset');
                        removeLoading('.modal-body');
                        $('.modal-footer button').prop('disabled', false);
                        $('#modalVideo').modal('hide');
                        loadVideo();
                    }
                });
            });

            $(document).on('click', '.btn-icon-only', function() {
                let id = $(this).data('id');
                
                if( confirm('Apakah Anda yakin ingin menghapus data ini?') ) {
                    $.ajax({
                        type    : 'post',
                        url     : '<?=base_url('admin/video/isi/hapus');?>',
                        dataType: 'json',
                        data    : { id : id },
                        beforeSend: function() {
                            loading('.card');
                        },
                        success : function(data) {
                            showAlert(data);
                        },
                        error   : function(e) {
                            toastr.error('Gagal menghapus data.', 'Error!');
                        },
                        complete: function() {
                            removeLoading('.card');
                            loadVideo();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>