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
            "url": base_url+"latihanmodul/list_json",
            "type": "POST",
        },
        columns: [
            {
                "data": "id_latihan",
                "orderable": false,
                "searchable": false
            },
            { "data": 'nama_latihan' },
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
                    "id_latihan": "id_latihan",
                    "ada": "ada"
                },
                "render": function (data, type, row, meta) {
                    var btn;
                    if (data.ada > 0) {
                        btn = `
								<a class="btn btn-xs btn-success" href="${base_url}hasillatihan/cetak/${data.id_latihan}" target="_blank">
									<i class="fa fa-print"></i> Cetak Hasil
								</a>`;
                    } else {
                        btn = `<a class="btn btn-xs btn-primary" href="${base_url}latihanmodul/token/${data.id_latihan}">
								<i class="fa fa-pencil"></i> Ikut latihanmodul
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