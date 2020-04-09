<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
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
    <style>
        @media (max-width: 767px) {
            .duration {
                display: block;
            }
            .duration::before {
                content: "(";
            }
        }
        @media (min-width: 768px) {
            .duration::before {
                content: " (";
                white-space: pre;
            }
        }
        .duration::after {
            content: ')';
        }
    </style>
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
                                            <button class="btn btn-success btn-icon-text mb-4" data-toggle="modal" data-target="#modalEdit">
                                                <i class="mdi mdi-pencil btn-icon-prepend"></i>
                                                Edit video
                                            </button>
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
                                                    <h5 class="mb-2">Deskripsi Singkat</h5>
                                                    <div class="ml-4 mb-0 font-weight-light">
                                                        <?=$video['deskripsi_singkat'];?>
                                                    </div>
                                                </div>
                                                <div class="mb-4 flex-grow">
                                                    <h5 class="mb-2">Harga Paket</h5>
                                                    <div class="ml-4 mb-0 font-weight-light">
                                                        <?='Rp ' . number_format($video['harga_paket'], 2, ',', '.');?>
                                                    </div>
                                                </div>
                                                <div class="mb-4 flex-grow">
                                                    <h5 class="mb-2">Link</h5>
                                                    <div class="ml-4 mb-0 font-weight-light">
                                                        <?=$video['link_video'];?>
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
                                            <button class="btn btn-info btn-icon-text mb-4" data-toggle="modal" data-target="#modalVideo">
                                                <i class="mdi mdi-plus btn-icon-prepend"></i>
                                                Tambah video
                                            </button>
                                            <ul class="list-group">
                                                
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
                            <div id="progress" style="display: none;">
                                <p></p>
                                <div class="progress" style="height: 15px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
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

    <div id="modalEdit" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Paket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form>
                                <div class="form-group">
                                    <label for="nama">Nama Paket Video</label>
                                    <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" value="<?=$video['nama_paket'];?>">
                                    <div class="invalid-feedback">Nama paket harus diisi</div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi Paket</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" autocomplete="off"><?=$video['deskripsi_paket'];?></textarea>
                                    <div class="invalid-feedback">Deskripsi paket harus diisi</div>
                                </div>
                                <div class="form-group">
                                    <label for="singkat">Deskripsi Singkat</label>
                                    <textarea id="singkat" name="singkat" class="form-control" rows="3" autocomplete="off"><?=$video['deskripsi_singkat'];?></textarea>
                                    <div class="invalid-feedback">Deskripsi singkat harus diisi</div>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga Paket</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark text-white">Rp</span>
                                        </div>
                                        <input type="text" name="harga" id="harga" class="form-control input-currency" autocomplete="off" value="<?=number_format($video['harga_paket'], 0, ',', '.');?>">
                                        <div class="invalid-feedback">Harga paket harus diisi</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="link">Link</label>
                                    <input type="text" name="link" id="link" class="form-control" autocomplete="off" value="<?=$video['link_video'];?>">
                                    <div class="invalid-feedback">Link harus diisi</div>
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail</label>
                                    <input type="file" accept="image/*" name="thumbnail" id="thumbnail">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-info" id="btnSimpanEdit">Simpan</button>
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
        function checkAlert() {
            let type = '<?=$this->session->flashdata('type');?>';
            let message = '<?=$this->session->flashdata('message');?>';
            if(type != '' && message != '') toastr.success(message, 'Sukses!');
        }

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
                                '<div class="d-flex-row">' +
                                    data[i].nama_video +
                                    '<span class="duration">'+data[i].durasi_video+'</span>' +
                                '</div>' +
                                '<span class="btn-icon-only badge badge-danger badge-pill" data-id="'+data[i].id_video+'">' +
                                    '<i class="fa fa-times"></i>' +
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
            $('#upload').filestyle({
                dragdrop : false,
                text : 'Upload video',
                btnClass : 'btn-info btn-file',
                buttonBefore : true,
            });
            $('#thumbnail').filestyle({
                dragdrop : false,
                text : 'Upload thumbnail',
                btnClass : 'btn-info btn-file',
                buttonBefore : true,
            });

            checkAlert();
            loadVideo();

            $('#btnSimpan').click(function(event) {
                event.preventDefault();
                let id = window.location.href.split('/');
                id = id[id.length - 1];
                let formData = new FormData();
                formData.append('id', id);
                formData.append('judul', $('#judul').val().trim());
                formData.append('video', $('#upload')[0].files[0]);
                
                let promise = new Promise(function(resolve, reject) {
                    let video = document.createElement('video');
                    video.src = URL.createObjectURL($('#upload')[0].files[0]);
                    video.ondurationchange = function() {
                        hour = Math.floor(video.duration / 3600);
                        minute = Math.floor( (video.duration % 3600) / 60 );
                        second = Math.floor( (video.duration % 3600) % 60 );

                        hour = (hour < 10) ? '0'+hour : hour;
                        minute = (minute < 10) ? '0'+minute : minute;
                        second = (second < 10) ? '0'+second : second;
                        
                        resolve(hour + ':' + minute + ':' + second);
                    }
                });

                promise.then(function(result) {
                    // resolve callback
                    formData.append('durasi', result);
                    $.ajax({
                        xhr     : function() {
                            let xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(e) {
                                if(e.lengthComputable) {
                                    let percent = Math.round((e.loaded / e.total) * 100);
                                    $('.progress-bar').attr('aria-valuenow', percent).css('width', percent + '%');
                                    if(percent == 100) {
                                        $('#progress p').text('Processing file...');
                                    }
                                }
                            });
                            return xhr;
                        },
                        type    : 'post',
                        url     : '<?=base_url('admin/video/isi/tambah');?>',
                        dataType: 'json',
                        data    : formData,
                        contentType : false,
                        processData : false,
                        beforeSend: function() {
                            $('#progress').show();
                            $('#progress p').text('Uploading files...');
                            $('.modal-footer button').prop('disabled', true);
                        },
                        success : function(data) {
                            showAlert(data);
                        },
                        error   : function(e) { console.log(e.responseText);
                            toastr.error('Gagal menyimpan data.', 'Error!');
                        },
                        complete: function() {
                            $('#formVideo').trigger('reset');
                            $('#progress').hide();
                            $('#progress p').text('');
                            $('.progress-bar').attr('aria-valuenow', 0).css('width', '0%');
                            $('.modal-footer button').prop('disabled', false);
                            $('#modalVideo').modal('hide');
                            loadVideo();
                        }
                    });
                }, function(result) {
                    // reject callback
                    toastr.error('Gagal menyimpan data.', 'Error!');
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

            $('#btnSimpanEdit').click(function(event) {
                event.preventDefault();
                $('.is-invalid').removeClass('is-invalid');

                let id = window.location.href.split('/');
                id = id[id.length - 1];
                let nama = $('#nama').val().trim();
                let deskripsi = $('#deskripsi').val().trim();
                let singkat = $('#singkat').val().trim();
                let harga = $('#harga').val().replace(/\./g, '');
                let link = $('#link').val().trim();
                let thumbnail = $('#thumbnail')[0];

                if(nama == '' || deskripsi == '' || singkat == '' || harga == '' || link == '') {
                    toastr.error('Data tidak lengkap.', 'Error!');
                    scrollToTop();
                    if(nama == '') $('#nama').addClass('is-invalid');
                    if(deskripsi == '') $('#deskripsi').addClass('is-invalid');
                    if(singkat == '') $('#singkat').addClass('is-invalid');
                    if(harga == '') $('#harga').addClass('is-invalid');
                    if(link == '') $('#link').addClass('is-invalid');
                }
                else {
                    if(thumbnail.files.length == 0) thumbnail = '';
                    else thumbnail = thumbnail.files[0]

                    let formData = new FormData();
                    formData.append('id', id);
                    formData.append('nama', nama);
                    formData.append('deskripsi', deskripsi);
                    formData.append('singkat', singkat);
                    formData.append('harga', harga);
                    formData.append('link', link);
                    formData.append('thumbnail', thumbnail);
                    
                    $.ajax({
                        type    : 'post',
                        url     : '<?=base_url('admin/video/edit');?>',
                        dataType: 'json',
                        data    : formData,
                        contentType : false,
                        processData : false,
                        beforeSend  : function() {
                            loading('.modal-body');
                        },
                        success : function(response) {
                            if(response.type == 'success') {
                                window.location = '<?=base_url('admin/video/detail/');?>' + id;
                            }
                            else {
                                showAlert(response);
                            }
                        },
                        error   : function(e) {
                            scrollToTop();
                            toastr.error('Gagal menyimpan data.', 'Error!');
                        },
                        complete: function() {
                            removeLoading('.modal-body');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>