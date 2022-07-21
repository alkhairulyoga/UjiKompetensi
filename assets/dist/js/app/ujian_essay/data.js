var table;

$(document).ready(function () {

    ajaxcsrf();

    table = $("#ujian_essay").DataTable({
        initComplete: function () {
            var api = this.api();
            $('#ujian_essay_filter input')
                .off('.DT')
                .on('keyup.DT', function (e) {
                    api.search(this.value).draw();
                });
        },
        oLanguage: {
            sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {
            "url": base_url+"ujian_essay/json",
            "type": "POST",
        },
        columns: [
            {
                "data": "id_essay",
                "orderable": false,
                "searchable": false
            },
            {
                "data": "id_essay",
                "orderable": false,
                "searchable": false
            },
            { "data": 'nama_essay' },
            { "data": 'nama_klsp' },
            { "data": 'jumlah_soal' },
            { "data": 'waktu' },
            { "data": 'jenis' },
            {
                "data": 'token',
                "orderable": false
            }
        ],
        columnDefs: [
            {
                "targets": 0,
                "data": "id_essay",
                "render": function (data, type, row, meta) {
                    return `<div class="text-center">
									<input name="checked[]" class="check" value="${data}" type="checkbox">
								</div>`;
                }
            },
            {
                "targets": 7,
                "data": "token",
                "render": function (data, type, row, meta) {
                    return `<div class="text-center">
								<strong class="badge bg-purple">${data}</strong>
								</div>`;
                }
            },
            {
                "targets": 8,
                "data": "id_essay",
                "render": function (data, type, row, meta) {
                    return `<div class="text-center">
									<button type="button" data-id="${data}" class="btn btn-token btn-xs bg-purple">
										<i class="fa fa-refresh"></i>
									</button>
									<a href="${base_url}ujian_essay/edit/${data}" class="btn btn-xs btn-warning">
										<i class="fa fa-edit"></i>
									</a>
								</div>`;
                }
            },
        ],
        order: [
            [1, 'desc']
        ],
        rowId: function (a) {
            return a;
        },
        rowCallback: function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(1)', row).html(index);
        }
    });

    $('.select_all').on('click', function () {
        if (this.checked) {
            $('.check').each(function () {
                this.checked = true;
                $('.select_all').prop('checked', true);
            });
        } else {
            $('.check').each(function () {
                this.checked = false;
                $('.select_all').prop('checked', false);
            });
        }
    });

    $('#ujian_essay tbody').on('click', 'tr .check', function () {
        var check = $('#ujian_essay tbody tr .check').length;
        var checked = $('#ujian_essay tbody tr .check:checked').length;
        if (check === checked) {
            $('.select_all').prop('checked', true);
        } else {
            $('.select_all').prop('checked', false);
        }
    });

    $('#ujian_essay').on('click', '.btn-token', function () {
        let id = $(this).data('id');

        $(this).attr('disabled', 'disabled').children().addClass('fa-spin');
        $.ajax({
            url: base_url+'ujian_essay/refresh_token/' + id,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    $(this).removeAttr('disabled');
                    reload_ajax();
                }
            }
        });
    });

    $('#bulk').on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            success: function (respon) {
                if (respon.status) {
                    Swal({
                        "title": "Berhasil",
                        "text": respon.total + " data berhasil dihapus",
                        "type": "success"
                    });
                } else {
                    Swal({
                        "title": "Gagal",
                        "text": "Tidak ada data yang dipilih",
                        "type": "error"
                    });
                }
                reload_ajax();
            },
            error: function () {
                Swal({
                    "title": "Gagal",
                    "text": "Ada data yang sedang digunakan",
                    "type": "error"
                });
            }
        });
    });

    table.ajax.url(base_url+'ujian_essay/json/'+id_dosen).load();
});

function bulk_delete() {
    if ($('#ujian_essay tbody tr .check:checked').length == 0) {
        Swal({
            title: "Gagal",
            text: 'Tidak ada data yang dipilih',
            type: 'error'
        });
    } else {
        Swal({
            title: 'Anda yakin?',
            text: "Data akan dihapus!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!'
        }).then((result) => {
            if (result.value) {
                $('#bulk').submit();
            }
        });
    }
}