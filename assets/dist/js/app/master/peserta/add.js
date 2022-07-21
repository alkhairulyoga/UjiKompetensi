function load_jurusan() {
    $('#klsp').find('option').not(':first').remove();

    $.getJSON(base_url+'level/load_klsp', function (data) {
        var option = [];
        for (let i = 0; i < data.length; i++) {
            option.push({
                id: data[i].id_klsp,
                text: data[i].nama_klsp
            });
        }
        $('#klsp').select2({
            data: option
        })
    });
}

function load_skema() {
    $('#skema').find('option').not(':first').remove();

    $.getJSON(base_url+'skema/load_skema', function (data) {
        var option = [];
        for (let i = 0; i < data.length; i++) {
            option.push({
                id: data[i].id_skema,
                text: data[i].nama_skema
            });
        }
        $('#skema').select2({
            data: option
        })
    });
}

$(document).ready(function () {

    ajaxcsrf();

    // Load Level
    load_jurusan();
    load_skema();

    // Load Skema By Level
    $('#jurusan').on('change', function () {
        load_skema($(this).val());
    });

    $('form#peserta input, form#peserta select').on('change', function () {
        $(this).closest('.form-group').removeClass('has-error has-success');
        $(this).nextAll('.help-block').eq(0).text('');
    });

    $('[name="jenis_kelamin"]').on('change', function () {
        $(this).parent().nextAll('.help-block').eq(0).text('');
    });

    $('form#peserta').on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var btn = $('#submit');
        btn.attr('disabled', 'disabled').text('Wait...');

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            success: function (data) {
                btn.removeAttr('disabled').text('Simpan');
                if (data.status) {
                    Swal({
                        "title": "Sukses",
                        "text": "Data Berhasil disimpan",
                        "type": "success"
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = base_url+'peserta';
                        }
                    });
                } else {
                    console.log(data.errors);
                    $.each(data.errors, function (key, value) {
                        $('[name="' + key + '"]').nextAll('.help-block').eq(0).text(value);
                        $('[name="' + key + '"]').closest('.form-group').addClass('has-error');
                        if (value == '') {
                            $('[name="' + key + '"]').nextAll('.help-block').eq(0).text('');
                            $('[name="' + key + '"]').closest('.form-group').removeClass('has-error').addClass('has-success');
                        }
                    });
                }
            }
        });
    });
});