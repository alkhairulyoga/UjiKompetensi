$(document).ready(function () {
    ajaxcsrf();

    $('#btncek').on('click', function () {
        var token = $('#token').val();
        var idujian_essay = $(this).data('id');
        if (token === '') {
            Swal('Gagal', 'Token harus diisi', 'error');
        } else {
            var key = $('#id_essay').data('key');
            $.ajax({
                url: base_url + 'ujian_essay/cektoken/',
                type: 'POST',
                data: {
                    id_essay: idujian_essay,
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
                            location.href = base_url + 'ujian_essay/?key=' + key;
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