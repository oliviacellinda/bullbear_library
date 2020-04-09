const base_url = {
    index   : 'http://localhost/bullbear_library/',
    admin   : 'http://localhost/bullbear_library/admin/',
    member  : 'http://localhost/bullbear_library/member/',
};

const currency = new Intl.NumberFormat('id-ID', {
    style	: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 2
});

function loading(element) {
    let loading = '<div class="loading"><i class="mdi mdi-reload"></i></div>';
    $(element).append(loading);
}

function removeLoading(element) {
    $(element).find('.loading').remove();
}

function showAlert(data) {
    if(data.type == 'success') {
        toastr.success(data.message, 'Success!');
    }
    else if(data.type == 'error') {
        toastr.error(data.message, 'Error!');
    }
    else if(data.type == 'info') {
        toastr.info(data.message, 'Information');
    }
}

function showEllipsis(element) {
    $(element).html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
}

function removeEllipsis(element) {
    $(element).find('.lds-ellipsis').remove();
}

function scrollToTop() {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    return false;
}

$(document).on('input', '.input-currency', function() {
    let nilai = $(this).val();
    if(/[^\d]/g.test(nilai)) {
        nilai = nilai.replace(/[^\d]/g, '');
        $(this).val(nilai);
    }

    if(nilai != '') {
        nilai = parseInt(nilai);
        $(this).val(nilai.toLocaleString('id'));
    }
});


$('#btnSimpanPasswordAdmin').click(function() {
    $('#password_lama').removeClass('is-invalid');
    $('#password_baru').removeClass('is-invalid');
    $('#konfirmasi_password').removeClass('is-invalid');
    
    let lama = $('#password_lama').val();
    let baru = $('#password_baru').val();
    let konfirmasi = $('#konfirmasi_password').val();
    
    let flag = true;
    
    if(lama === '' || baru === '' || konfirmasi === '') {
        flag = false;
        if(lama === '') {
            $('#password_lama').siblings('.invalid-feedback').text('Password lama harus diisi.');
            $('#password_lama').addClass('is-invalid');
        }
        if(baru === '') {
            $('#password_baru').siblings('.invalid-feedback').text('Password baru harus diisi.');
            $('#password_baru').addClass('is-invalid');
        }
        if(konfirmasi === '') {
            $('#konfirmasi_password').siblings('.invalid-feedback').text('Konfirmasi password baru harus diisi.');
            $('#konfirmasi_password').addClass('is-invalid');
        }
    }
    
    if(baru.length < 8) {
        flag = false;
        $('#password_baru').siblings('.invalid-feedback').text('Password baru minimal terdiri dari 8 karakter.');
        $('#password_baru').addClass('is-invalid');
    }
    
    if(konfirmasi != baru) {
        flag = false;
        $('#konfirmasi_password').siblings('.invalid-feedback').text('Konfirmasi password baru tidak sesuai.');
        $('#konfirmasi_password').addClass('is-invalid');
    }
    
    if(flag) {
        $.ajax({
            type    : 'post',
            url     : base_url.admin + 'gantiPassword',
            dataType: 'json',
            data    : {
                password_lama       : lama,
                password_baru       : baru,
                konfirmasi_password : konfirmasi,
            },
            beforeSend: function() {
                loading('.modal-body');
            },
            success : function(response) {
                if(response.type == 'success') {
                    $('#password_lama').val('');
                    $('#password_baru').val('');
                    $('#konfirmasi_password').val('');
                    $('#modalPassword').modal('hide');
                }
                showAlert(response);
            },
            error   : function(response) {
                toastr.error('Gagal menyimpan data.', 'Error!');
            },
            complete: function() {
                removeLoading('.modal-body');
            }
        })
    }
});

$('#btnSimpanPasswordMember').click(function() {
    $('.has-danger').removeClass('has-danger');
    $('.form-control-feedback').text('');
    
    let lama = $('#password_lama').val();
    let baru = $('#password_baru').val();
    let konfirmasi = $('#konfirmasi_password').val();
    
    let flag = true;
    
    if(lama === '' || baru === '' || konfirmasi === '') {
        flag = false;
        if(lama === '') {
            $('#password_lama').siblings('.form-control-feedback').text('Old password is required.');
            $('#password_lama').parent('.form-group').addClass('has-danger');
        }
        if(baru === '') {
            $('#password_baru').siblings('.form-control-feedback').text('New password is required.');
            $('#password_baru').parent('.form-group').addClass('has-danger');
        }
        if(konfirmasi === '') {
            $('#konfirmasi_password').siblings('.form-control-feedback').text('Confirmation password is required.');
            $('#konfirmasi_password').parent('.form-group').addClass('has-danger');
        }
    }
    
    if(baru.length < 8) {
        flag = false;
        $('#password_baru').siblings('.form-control-feedback').text('The minimum length of password is 8 characters.');
        $('#password_baru').parent('.form-group').addClass('has-danger');
    }
    
    if(konfirmasi != baru) {
        flag = false;
        $('#konfirmasi_password').siblings('.form-control-feedback').text('Confirmation password does not match.');
        $('#konfirmasi_password').parent('.form-group').addClass('has-danger');
    }
    
    if(flag) {
        $.ajax({
            type    : 'post',
            url     : base_url.member + 'changePassword',
            dataType: 'json',
            data    : {
                password_lama       : lama,
                password_baru       : baru,
                konfirmasi_password : konfirmasi,
            },
            beforeSend: function() {
                $('.loading').removeClass('d-none');
            },
            success : function(response) {
                if(response.type == 'success') {
                    $('#password_lama').val('');
                    $('#password_baru').val('');
                    $('#konfirmasi_password').val('');
                    $('#modalPassword').modal('hide');
                }
                showAlert(response);
            },
            error   : function(response) {
                toastr.error('Failed changing password.', 'Error!');
            },
            complete: function() {
                $('.loading').addClass('d-none');
            }
        })
    }
});