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

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Tambah Paket Baru</h4>
                                    <p class="card-description">Masukkan data paket video baru</p>
                                    <div class="col-md-6">
                                        <form id="formVideo" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="nama">Nama Paket Video</label>
                                                <input type="text" name="nama" id="nama" class="form-control" autocomplete="off">
                                                <div class="invalid-feedback">Nama paket harus diisi</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi Paket</label>
                                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" autocomplete="off"></textarea>
                                                <div class="invalid-feedback">Deskripsi paket harus diisi</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="singkat">Deskripsi Singkat</label>
                                                <textarea name="singkat" id="singkat" class="form-control" rows="3" autocomplete="off"></textarea>
                                                <div class="invalid-feedback">Deskripsi singkat harus diisi</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga Paket</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-dark text-white">Rp</span>
                                                    </div>
                                                    <input type="text" name="harga" id="harga" class="form-control input-currency" autocomplete="off">
                                                    <div class="invalid-feedback">Harga paket harus diisi</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="link">Link</label>
                                                <input type="text" name="link" id="link" class="form-control" autocomplete="off">
                                                <div class="invalid-feedback">Link harus diisi</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="thumbnail">Thumbnail</label>
                                                <input type="file" accept="image/*" name="thumbnail" id="thumbnail">
                                                <div class="invalid-feedback">Thumbnail harus diupload</div>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-info"><i class="mdi mdi-save"></i> Simpan</button>
                                            </div>
                                        </form>
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
        $(document).ready(function() {
            $('#navVideo').addClass('active');

            $(':file').filestyle({
                dragdrop : false,
                text : 'Upload gambar',
                btnClass : 'btn-info btn-file',
                buttonBefore : true,
            });

            $('form').submit(function(event) {
                event.preventDefault();
                $('.is-invalid').removeClass('is-invalid');
                $('#thumbnail').parents('.form-group').find('.invalid-feedback').css('display', 'none');

                let nama = $('#nama').val().trim();
                let deskripsi = $('#deskripsi').val().trim();
                let singkat = $('#singkat').val().trim();
                let harga = $('#harga').val().replace(/\./g, '');
                let link = $('#link').val().trim();
                let thumbnail = $('#thumbnail')[0];

                if(nama == '' || deskripsi == '' || singkat == '' || harga == '' || link == '' || thumbnail.files.length == 0) {
                    toastr.error('Data tidak lengkap.', 'Error!');
                    scrollToTop();
                    if(nama == '') $('#nama').addClass('is-invalid');
                    if(deskripsi == '') $('#deskripsi').addClass('is-invalid');
                    if(singkat == '') $('#singkat').addClass('is-invalid');
                    if(harga == '') $('#harga').addClass('is-invalid');
                    if(link == '') $('#link').addClass('is-invalid');
                    if(thumbnail.files.length == 0) $('#thumbnail').parents('.form-group').find('.invalid-feedback').css('display', 'block');
                }
                else {
                    let formData = new FormData();
                    formData.append('nama', nama);
                    formData.append('deskripsi', deskripsi);
                    formData.append('singkat', deskripsi);
                    formData.append('harga', harga);
                    formData.append('link', link);
                    formData.append('thumbnail', thumbnail.files[0]);
                    
                    $.ajax({
                        type    : 'post',
                        url     : '<?=base_url('admin/video/tambah/proses');?>',
                        dataType: 'json',
                        data    : formData,
                        contentType : false,
                        processData : false,
                        beforeSend  : function() {
                            loading('.card');
                        },
                        success : function(response) {
                            if(response.type == 'success') {
                                window.location = '<?=base_url('admin/video/detail/');?>' + response.message;
                            }
                            else {
                                showAlert(response);
                            }
                        },
                        error   : function() {
                            scrollToTop();
                            toastr.error('Gagal menyimpan data.', 'Error!');
                        },
                        complete: function() {
                            removeLoading('.card');
                        }
                    });
                }

            });
        });
    </script>
</body>
</html>