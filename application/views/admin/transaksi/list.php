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

                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-12">
                            <a href="<?=base_url('admin/transaksi/tambah');?>" class="btn btn-info btn-icon-text">
                                <i class="mdi mdi-plus btn-icon-prepend"></i>
                                Tambah transaksi
                            </a>
                        </div>
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

    <div id="modalDetail" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="nav-transaksi-tab" data-toggle="pill" href="#nav-transaksi" role="tab" aria-controls="nav-transaksi" aria-selected="true">Transaksi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-member-tab" data-toggle="pill" href="#nav-member" role="tab" aria-controls="nav-member" aria-selected="false">Member</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-paket-tab" data-toggle="pill" href="#nav-paket" role="tab" aria-controls="nav-paket" aria-selected="false">Paket</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-transaksi" role="tabpanel" aria-labelledby="nav-transaksi-tab">
                                    <div>
                                        <h5>Invoice</h5>
                                        <p id="invoice"></p>
                                    </div>
                                    <div>
                                        <h5>Tanggal Transaksi</h5>
                                        <p id="tglTransaksi"></p>
                                    </div>
                                    <div>
                                        <h5>Tanggal Verifikasi</h5>
                                        <p id="tglVerifikasi"></p>
                                    </div>
                                    <div>
                                        <h5>Total Pembelian</h5>
                                        <p id="totalPembelian"></p>
                                    </div>
                                    <div>
                                        <h5>Status Verifikasi</h5>
                                        <p id="statusVerifikasi"></p>
                                    </div>
                                    <div>
                                        <h5>Sumber Pembayaran</h5>
                                        <p id="sumberPembayaran"></p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-member" role="tabpanel" aria-labelledby="nav-member-tab">
                                    <div>
                                        <h5>Nama Member</h5>
                                        <p id="namaMember"></p>
                                    </div>
                                    <div>
                                        <h5>Username Member</h5>
                                        <p id="usernameMember"></p>
                                    </div>
                                    <div>
                                        <h5>Email Member</h5>
                                        <p id="emailMember"></p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-paket" role="tabpanel" aria-labelledby="nav-paket-tab">
                                    <div>
                                        <h5>Nama Paket</h5>
                                        <p id="namaPaket"></p>
                                    </div>
                                    <div>
                                        <h5>Deskripsi Paket</h5>
                                        <p id="deskripsiPaket"></p>
                                    </div>
                                    <div>
                                        <h5>Harga Paket</h5>
                                        <p id="hargaPaket"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
                                'username_member'   : datatable.data[i].username_member,
                                'total_pembelian'   : datatable.data[i].total_pembelian,
                                'status_verifikasi' : datatable.data[i].status_verifikasi,
                            });
                        }
                        return returnData;
                    },
                    error : function(e) {
                        window.location = "<?=base_url('admin/login');?>";
                    }
                },
                columns : [
                    { data : 'menu', orderable : false },
                    { data : 'tanggal_transaksi' },
                    { data : 'invoice' },
                    { data : 'username_member' },
                    { data : 'total_pembelian' },
                    { data : 'status_verifikasi' },
                ],
                columnDefs : [
                    { targets : 0, render : function(data, type, row) {
                            let button = '<button id="btnDetail" class="btn btn-sm btn-primary">' +
                                '<i class="mdi mdi-information"></i>' +
                            '</button>';
                            return button;
                        } 
                    },
                    { targets : 1, render : function(data, type, row) {
                            if(moment(data).isValid())
                                return moment(data, 'YYYY-MM-DD HH:mm:ss', 'id').format('D MMMM YYYY, HH:mm');
                            else
                                return "-";
                        } 
                    },
                    { targets : 4, render : $.fn.dataTable.render.number('.', ',', 2, 'Rp ') },
                    { targets : 5, render : function(data, type, row) {
                            return data.charAt(0).toUpperCase() + data.slice(1);
                        } 
                    },
                ],
            });

            $('#tabelTransaksi').on('click', '#btnDetail', function() {
                let tr = $(this).parents('tr');
                let row = tabel.row(tr).data();

                $.ajax({
                    type    : 'post',
                    url     : '<?=base_url('admin/transaksi/detail');?>',
                    dataType: 'json',
                    data    : { invoice : row.menu },
                    beforeSend: function() {
                        loading('.card');
                    },
                    success : function(data) { console.log(data);
                        if(data.type == 'error') {
                            showAlert(data);
                        }
                        else if(data.type == 'success') {
                            $('#invoice').text(data.transaksi.invoice);
                            $('#tglTransaksi').text(moment(data.transaksi.tanggal_transaksi).isValid() ? moment(data.transaksi.tanggal_transaksi, 'YYYY-MM-DD HH:mm:ss', 'id').format('D MMMM YYYY, HH:mm') : '-');
                            $('#tglVerifikasi').text(moment(data.transaksi.tanggal_verifikasi).isValid() ? moment(data.transaksi.tanggal_verifikasi, 'YYYY-MM-DD HH:mm:ss', 'id').format('D MMMM YYYY, HH:mm') : '-');
                            $('#totalPembelian').text(currency.format(data.transaksi.total_pembelian));
                            $('#statusVerifikasi').text(data.transaksi.status_verifikasi.charAt(0).toUpperCase() + data.transaksi.status_verifikasi.slice(1));
                            $('#sumberPembayaran').text(data.transaksi.sumber_pembayaran.charAt(0).toUpperCase() + data.transaksi.sumber_pembayaran.slice(1));
                        
                            $('#namaMember').text(data.member.nama_member);
                            $('#usernameMember').text(data.member.username_member);
                            $('#emailMember').text(data.member.email_member);

                            if(data.paket == null) {
                                $('#namaPaket,#deskripsiPaket,#hargaPaket').text('Data tidak ditemukan.');
                            }
                            else {
                                $('#namaPaket').text(data.paket.nama_paket);
                                $('#deskripsiPaket').text(data.paket.deskripsi_paket);
                                $('#hargaPaket').text(currency.format(data.paket.harga_paket));
                            }
                            
                            $('#nav-transaksi').tab('show');
                            $('#modalDetail').modal('show');
                        }
                    },
                    error   : function(e) {
                        toastr('error', 'Gagal memuat data.');
                    },
                    complete: function() {
                        removeLoading('.card');
                    }
                });
            });
        });
    </script>
</body>
</html>