<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Datatables</h5>
                    <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable</p>

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Position</th>
                                <th scope="col">Age</th>
                                <th scope="col">Start Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Brandon Jacob</td>
                                <td>Designer</td>
                                <td>28</td>
                                <td>2016-05-25</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Bridie Kessler</td>
                                <td>Developer</td>
                                <td>35</td>
                                <td>2014-12-05</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Ashleigh Langosh</td>
                                <td>Finance</td>
                                <td>45</td>
                                <td>2011-08-12</td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Angus Grady</td>
                                <td>HR</td>
                                <td>34</td>
                                <td>2012-06-11</td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Raheem Lehner</td>
                                <td>Dynamic Division Officer</td>
                                <td>47</td>
                                <td>2011-04-19</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
    </div>
</section>


<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body d-flex justify-content-center">
                    <h3 class="card-title"><?= $subjudul ?></h3>
                    <div class="button d-flex justify-content-end">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>



                <div class="card-body ">
                    <button type="button" onclick="bulk_delete()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Bulk Delete</button>
                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('ujian/add') ?>" class="btn btn-primary btn-sm"> Ujian Baru</a>
                        <button type="button" onclick="reload_ajax()" class="btn btn-info btn-sm"> Reload</button>

                    </div>
                </div>



                <?= form_open('ujian/delete', array('id' => 'bulk')) ?>
                <div class="table-responsive px-4 pb-3" style="border: 0">
                    <table id="ujian" table class="table datatable">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" class="select_all">
                                </th>
                                <th>No.</th>
                                <th>Nama Ujian</th>
                                <th>Skema LSP</th>
                                <th>Jumlah Soal</th>
                                <th>Waktu</th>
                                <th>Acak Soal</th>
                                <th class="text-center">Token</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" class="select_all">
                                </th>
                                <th>No.</th>
                                <th>Nama Ujian</th>
                                <th>Nama KLSP</th>
                                <th>Jumlah Soal</th>
                                <th>Waktu</th>
                                <th>Acak Soal</th>
                                <th class="text-center">Token</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?= form_close(); ?>
            </div>

            <script type="text/javascript">
                var id_dosen = '<?= $dosen->id_dosen ?>';
            </script>

            <script src="<?= base_url() ?>assets/dist/js/app/ujian/data.js"></script>

        </div>
    </div>
</section>