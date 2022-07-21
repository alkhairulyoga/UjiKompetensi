$(document).ready(function () {
    ajaxcsrf();

    $('#btncek').on('click', function () {
        var token = $('#token').val();
        var idujian_praktek = $(this).data('id');
        if (token === '') {
            Swal('Gagal', 'Token harus diisi', 'error');
        } else {
            var key = $('#id_praktek').data('key');
            $.ajax({
                url: base_url + 'ujian_praktek/cektoken/',
                type: 'POST',
                data: {
                    id_praktek: idujian_praktek,
                    token: token
                },
                cache: false,
                success: function (result) {
                    Swal({
                        "type": result.status ? "success" : "error",
                        "title": result.status ? "Berhasil" : "Gagal",
                        "text": result.status ? "Token Benar" : "Token Salah"
                    }).then((data) => {
                        if(result.status){
                            location.href = base_url + 'ujian_praktek/?key=' + key;
                        }
                    });
                }
            });
        }
    });

    var time = $('.countdown');
    if (time.length) {
        countdown(time.data('time'));
    }
});