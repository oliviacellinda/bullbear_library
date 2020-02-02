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
    <link rel="stylesheet" href="<?=base_url('assets/font-awesome/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/datatable/DataTables-1.10.20/css/dataTables.bootstrap4.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/toastr/toastr.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/select2/dist/css/select2.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/lds-ellipsis.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/style.css');?>">
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #ebedf2;
            border-radius: 0px;
            font-size: 0.8125rem;
            height: 2.875rem;
            padding: 1rem .75rem;
            color: #888;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #888;
            line-height: 1;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
        }
        .select2-dropdown {
            border: 1px solid #ebedf2;
            border-radius: 0px;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #ebedf2;
        }
        .select2-results__option {
            padding: 0.3rem 1.4rem;
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
                        <h3 class="page-title"> Manajemen Transaksi </h3>
                    </div>

                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Tambah Transaksi</h4>
                                    <p class="card-description">Masukkan data transaksi baru</p>
                                    <div class="col-md-6">
                                        <form id="formTransaksi">
                                            <div class="form-group">
                                                <label for="member">Member</label>
                                                <select class="form-control" name="member" id="member">
                                                    <option value=""></option>
                                                </select>
                                                <div class="invalid-feedback">Member harus diisi</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="jenis">Jenis Paket</label>
                                                <select class="form-control" name="jenis" id="jenis">
                                                    <option value=""></option>
                                                    <option value="video">Video</option>
                                                    <option value="ebook">Ebook</option>
                                                </select>
                                                <div class="invalid-feedback">Jenis paket harus diisi</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="paket">Nama Paket</label>
                                                <select class="form-control" name="paket" id="paket">
                                                    <option value=""></option>
                                                </select>
                                                <div class="invalid-feedback">Nama paket harus diisi</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi Paket</label>
                                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" autocomplete="off" readonly></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga Paket</label>
                                                <div class="input-group">
                                                    <input type="text" name="harga" id="harga" class="form-control input-currency" autocomplete="off" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button id="btnSimpan" class="btn btn-info"><i class="mdi mdi-save"></i> Simpan</button>
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
    <script src="<?=base_url('assets/select2/dist/js/select2.full.min.js');?>"></script>
    <script src="<?=base_url('assets/js/function.js');?>"></script>

    <script>
        $(document).ready(function() {
            $('#navTransaksi').addClass('active');
            $('#jenis').select2({placeholder : 'Pilih jenis paket', minimumResultsForSearch: -1});
            $('#paket').select2({placeholder : 'Pilih jenis paket terlebih dahulu.'});

            $('#member').select2({
                ajax : {
                    type    : 'post',
                    url     : '<?=base_url('admin/user/search');?>',
                    dataType: 'json',
                    delay   : 250, // in miliseconds
                    data    : function(params) {
                        return { search : params.term };
                    },
                    processResults: function(data, params) {
                        if(data.results.length > 0) {
                            data.results.forEach(function(element) {
                                element.id = element.username_member;
                                element.text = element.nama_member;
                            });
                        }
                        return { results : data.results };
                    },
                },
                placeholder : 'Cari member berdasarkan username atau nama.',
                minimumInputLength : 2,
                templateResult : function formatSelect(data) {
                    if(data.loading) {
                        return data.text;
                    }
                    var template = $('<span><strong>'+data.username_member+'</strong> &mdash; '+data.nama_member+'</span>');
                    return template;
                },
                templateSelection : function formatSelection(data) {
                    return data.nama_member || data.text;
                },
            });

            $('#jenis').change(function() {
                let val = this.value;
                let url = '';
                if(this.value == 'video') url = '<?=base_url('admin/video/list');?>';
                else if(this.value == 'ebook') url = '<?=base_url('admin/ebook/list');?>';
                $.ajax({
                    type    : 'get',
                    url     : url,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#paket').empty();
                        $('#paket').append('<option value=""></option>');
                        $('#paket').select2({placeholder : 'Memuat data...'});
                    },
                    success : function(data) {
                        if(data == '' || data == undefined) {
                            $('#paket').empty();
                            $('#paket').append('<option value=""></option>');
                            $('#paket').select2({placeholder : 'Tidak ada data.'});
                        }
                        else {
                            for(let i=0; i<data.length; i++) {
                                let opt = $('<option></option>');
                                let value = {
                                    id          : ('id_video_paket' in data[i]) ? data[i].id_video_paket : data[i].id_ebook_paket,
                                    deskripsi   : data[i].deskripsi_paket,
                                    harga       : data[i].harga_paket,
                                };
                                value = JSON.stringify(value);
                                $(opt).prop('value', value);
                                $(opt).text(data[i].nama_paket);
                                $(opt).appendTo($('#paket'));
                            }
                            $('#paket').select2({placeholder : 'Pilih paket'});
                        }
                    },
                    error   : function() {
                        $('#paket').select2({placeholder : 'Gagal memuat data.'});
                    }
                });
            });

            $(document).on('change', '#paket', function() {
                let value = this.value;
                value = JSON.parse(value);
                $('#deskripsi').val(value.deskripsi);
                $('#harga').val(currency.format(value.harga));
            });

            $('#btnSimpan').click(function(event) {
                event.preventDefault();
                $('.is-invalid').removeClass('is-invalid');
                
                let username = $('#member').val();
                let jenis = $('#jenis').val();
                let paket = $('#paket').val();
                paket = JSON.parse(paket);
                paket = paket.id;

                if(username == '' || jenis == '' || paket == '') {
                    toastr.error('Data tidak lengkap.', 'Error!');
                    scrollToTop();
                    if(username == '') $('#username').addClass('is-invalid');
                    if(jenis == '') $('#jenis').addClass('is-invalid');
                    if(paket == '') $('#paket').addClass('is-invalid');
                }
                else {
                    $.ajax({
                        type    : 'post',
                        url     : '<?=base_url('admin/transaksi/tambah/proses');?>',
                        dataType: 'json',
                        data    : {
                            username    : username,
                            jenis       : jenis,
                            paket       : paket,
                        },
                        beforeSend: function() {
                            loading('.card');
                        },
                        success : function(response) {
                            if(response.type == 'success') {
                                window.location = '<?=base_url('admin/transaksi');?>';
                            }
                            else {
                                showAlert(response);
                            }
                        },
                        error   : function(e) { console.log(e.responseText);
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