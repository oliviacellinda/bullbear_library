function loading(element) {
    let loading = '<div class="loading"><i class="mdi mdi-reload"></i></div>';
    $(element).append(loading);
}

function removeLoading(element) {
    $(element).find('.loading').remove();
}

function showAlert(data) {
    if(data.type == 'success') {
        toastr.success(data.message, 'Sukses!');
    }
    else if(data.type == 'error') {
        toastr.error(data.message, 'Error!');
    }
}

function showEllipsis(element) {
    $(element).html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
}

function scrollToTop() {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    return false;
}

$(document).on('input', '.input-currency', function() {
    var nilai = $(this).val();
    if(/[^\d]/g.test(nilai)) {
        nilai = nilai.replace(/[^\d]/g, '');
        $(this).val(nilai);
    }

    if(nilai != '') {
        nilai = parseInt(nilai);
        $(this).val(nilai.toLocaleString('id'));
    }
});