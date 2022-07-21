<div class="row">

    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Ujian <span>| Today</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <div class="ps-3">
                        <h6>Skema</h6>
                        <span class="d-block"> <?= $mhs->nama_skema ?></span>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Ujian <span>| Today</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bx bxs-graduation"></i>
                    </div>
                    <div class="ps-3">
                        <h6>Level</h6>
                        <span class="d-block"> <?= $mhs->nama_level ?></span>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Ujian <span>| Today</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar-date"></i>
                    </div>
                    <div class="ps-3">
                        <h6>Jam</h6>
                        <span class="d-block"> <?= strftime('%A, %d %B %Y') ?></span>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Ujian <span>| Today</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="ps-3">
                        <h6>Tanggal</h6>
                        <span class="d-block"> <span class="live-clock"><?= date('H:i:s') ?></span></span>


                    </div>
                </div>
            </div>

        </div>
    </div>


    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="col-sm-12">
                        <div class="box">
                            <div class="card">
                                <div class="card-body d-flex justify-content-center">
                                    <h3 class="card-title"><?= $subjudul ?></h3>
                                    <div class="button d-flex justify-content-end">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <button type="button" onclick="reload_ajax()" class="btn btn-info btn-sm"> Reload</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive px-4 pb-3" style="border: 0">
                                    <table id="ujian_essay" class="table">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Essay</th>
                                                <th>Skema Lsp</th>
                                                <th>Pengajar</th>
                                                <th>Jumlah Soal</th>
                                                <th>Waktu</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Essay</th>
                                                <th>Skema Lsp</th>
                                                <th>Pengajar</th>
                                                <th>Jumlah Soal</th>
                                                <th>Waktu</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <script src="<?= base_url() ?>assets/dist/js/app/ujian_essay/list.js"></script>