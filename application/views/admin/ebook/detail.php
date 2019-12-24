<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manajemen Ebook - Admin</title>
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
                        <h3 class="page-title"> Manajemen Ebook </h3>
                    </div>

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Informasi Paket Ebook</h4>
                                    <div class="row">
                                        <div class="col-md-6 mt-5 separator-line">
                                            <button class="btn btn-success btn-icon-text mb-4" data-toggle="modal" data-target="#modalEdit">
                                                <i class="mdi mdi-pencil btn-icon-prepend"></i>
                                                Edit ebook
                                            </button>
                                            <div class="d-flex flex-column align-items-top">
                                                <div class="mb-4 flex-grow">
                                                    <h5 class="mb-2">Nama Paket Ebook</h5>
                                                    <div class="ml-4 mb-0 font-weight-light">
                                                        <?=$ebook['nama_paket'];?>
                                                    </div>
                                                </div>
                                                <div class="mb-4 flex-grow">
                                                    <h5 class="mb-2">Deskripsi Paket</h5>
                                                    <div class="ml-4 mb-0 font-weight-light">
                                                        <?=$ebook['deskripsi_paket'];?>
                                                    </div>
                                                </div>
                                                <div class="mb-4 flex-grow">
                                                    <h5 class="mb-2">Harga Paket</h5>
                                                    <div class="ml-4 mb-0 font-weight-light">
                                                        <?='Rp ' . number_format($ebook['harga_paket'], 2, ',', '.');?>
                                                    </div>
                                                </div>
                                                <div class="mb-4 flex-grow">
                                                    <h5 class="mb-2">Thumbnail</h5>
                                                    <div class="mb-0">
                                                        <img src="<?=base_url('course/ebook/thumbnail/'.$ebook['thumbnail_paket']);?>" alt="Thumbnail" style="width: 100%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-5">
                                                <button class="btn btn-info btn-icon-text mb-4" data-toggle="modal" data-target="#modalEbook">
                                                    <i class="mdi mdi-plus btn-icon-prepend"></i>
                                                    Tambah ebook
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

    <div id="modalEbook" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Ebook</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form id="formEbook" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="judul">Judul Ebook</label>
                                    <input type="text" id="judul" name="judul" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="upload">Upload Ebook</label>
                                    <input type="file" accept="ebook/*" id="upload" name="upload">
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
                                    <label for="nama">Nama Paket Ebook</label>
                                    <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" value="<?=$ebook['nama_paket'];?>">
                                    <div class="invalid-feedback">Nama paket harus diisi</div>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi Paket</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" autocomplete="off"><?=$ebook['deskripsi_paket'];?></textarea>
                                    <div class="invalid-feedback">Deskripsi paket harus diisi</div>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga Paket</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark text-white">Rp</span>
                                        </div>
                                        <input type="text" name="harga" id="harga" class="form-control input-currency" autocomplete="off" value="<?=number_format($ebook['harga_paket'], 0, ',', '.');?>">
                                        <div class="invalid-feedback">Harga paket harus diisi</div>
                                    </div>
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

        function loadEbook() {
            $.ajax({
                type    : 'post',
                url     : '<?=base_url('admin/ebook/isi/'.$ebook['id_ebook_paket']);?>',
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
                                data[i].nama_ebook +
                                '<span class="btn-icon-only badge badge-danger badge-pill" data-id="'+data[i].id_ebook+'">' +
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
            $('#navEbook').addClass('active');
            $('#upload').filestyle({
                dragdrop : false,
                text : 'Upload ebook',
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
            loadEbook();

            $('#btnSimpan').click(function(event) {
                event.preventDefault();
                let id = window.location.href.split('/');
                id = id[id.length - 1];
                let formData = new FormData();
                formData.append('id', id);
                formData.append('judul', $('#judul').val().trim());
                formData.append('ebook', $('#upload')[0].files[0]);
                
                $.ajax({
                    type    : 'post',
                    url     : '<?=base_url('admin/ebook/isi/tambah');?>',
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
                    error   : function(e) { console.log(e.responseText);
                        toastr.error('Gagal menyimpan data.', 'Error!');
                    },
                    complete: function() {
                        $('#formEbook').trigger('reset');
                        removeLoading('.modal-body');
                        $('.modal-footer button').prop('disabled', false);
                        $('#modalEbook').modal('hide');
                        loadEbook();
                    }
                });
            });

            $(document).on('click', '.btn-icon-only', function() {
                let id = $(this).data('id');
                
                if( confirm('Apakah Anda yakin ingin menghapus data ini?') ) {
                    $.ajax({
                        type    : 'post',
                        url     : '<?=base_url('admin/ebook/isi/hapus');?>',
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
                            loadEbook();
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
                let harga = $('#harga').val().replace(/\./g, '');
                let thumbnail = $('#thumbnail')[0];

                if(nama == '' || deskripsi == '' || harga == '') {
                    toastr.error('Data tidak lengkap.', 'Error!');
                    scrollToTop();
                    if(nama == '') $('#nama').addClass('is-invalid');
                    if(deskripsi == '') $('#deskripsi').addClass('is-invalid');
                    if(harga == '') $('#harga').addClass('is-invalid');
                }
                else {
                    if(thumbnail.files.length == 0) thumbnail = '';
                    else thumbnail = thumbnail.files[0]

                    let formData = new FormData();
                    formData.append('id', id);
                    formData.append('nama', nama);
                    formData.append('deskripsi', deskripsi);
                    formData.append('harga', harga);
                    formData.append('thumbnail', thumbnail);
                    
                    $.ajax({
                        type    : 'post',
                        url     : '<?=base_url('admin/ebook/edit');?>',
                        dataType: 'json',
                        data    : formData,
                        contentType : false,
                        processData : false,
                        beforeSend  : function() {
                            loading('.modal-body');
                        },
                        success : function(response) {
                            if(response.type == 'success') {
                                window.location = '<?=base_url('admin/ebook/detail/');?>' + id;
                            }
                            else {
                                showAlert(response);
                            }
                        },
                        error   : function(e) {
                            scrollToTop();
                            toastr.error('Gagal menyimpan data.', 'Error!');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>