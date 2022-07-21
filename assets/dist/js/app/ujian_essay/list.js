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
            "url": base_url+"ujian_essay/list_json",
            "type": "POST",
        },
        columns: [
            {
                "data": "id_essay",
                "orderable": false,
                "searchable": false
            },
            { "data": 'nama_essay' },
            { "data": 'nama_klsp' },
            { "data": 'nama_pengajar' },
            { "data": 'jumlah_soal' },
            { "data": 'waktu' },
            {
                "searchable": false,
                "orderable": false
            }
        ],
        columnDefs: [
            {
                "targets": 6,
                "data": {
                    "id_essay": "id_essay",
                    "ada": "ada"
                },
                "render": function (data, type, row, meta) {
                    var btn;
                    if (data.ada > 0) {
						
                    } else {
                        btn = `<a class="btn btn-xs btn-primary" href="${base_url}ujian_essay/token/${data.id_essay}">
								<i class="fa fa-pencil"></i> Ikut Ujian
							</a>`;
                    }
                    return `<div class="text-center">
									${btn}
								</div>`;
                }
            },
        ],
        order: [
            [1, 'asc']
        ],
        rowId: function (a) {
            return a;
        },
        rowCallback: function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        }
    });
});