var table;

$(document).ready(function () {

    ajaxcsrf();

    table = $("#latihanmodul").DataTable({
        initComplete: function () {
            var api = this.api();
            $('#latihanmodul_filter input')
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
            "url": base_url+"latihanmodul/json",
            "type": "POST",
        },
        columns: [
            {
                "data": "id_latihan",
                "orderable": false,
                "searchable": false
            },
            {
                "data": "id_latihan",
                "orderable": false,
                "searchable": false
            },
            { "data": 'nama_latihan' },
            { "data": 'nama_klsp' },
            { "data": 'jumlah_soal' },
            { "data": 'waktu' },
            { "data": 'jenis' },
        ],
        columnDefs: [
            {
                "targets": 0,
                "data": "id_latihan",
                "render": function (data, type, row, meta) {
                    return `<div class="text-center">
									<input name="checked[]" class="check" value="${data}" type="checkbox">
								</div>`;
                }
            },

            {
                "targets": 7,
                "data": "id_latihan",
                "render": function (data, type, row, meta) {
                    return `<div class="text-center">
						
									<a href="${base_url}latihanmodul/edit/${data}" class="btn btn-xs btn-warning">
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

    $('#latihanmodul tbody').on('click', 'tr .check', function () {
        var check = $('#latihanmodul tbody tr .check').length;
        var checked = $('#latihanmodul tbody tr .check:checked').length;
        if (check === checked) {
            $('.select_all').prop('checked', true);
        } else {
            $('.select_all').prop('checked', false);
        }
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

    table.ajax.url(base_url+'latihanmodul/json/'+id_pengajar).load();
});

function bulk_delete() {
    if ($('#latihanmodul tbody tr .check:checked').length == 0) {
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