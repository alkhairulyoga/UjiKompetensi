<?php if ($this->ion_auth->is_admin()) : ?>
    <div class="row">
        <?php foreach ($info_box as $info) : ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-<?= $info->box ?>">
                    <div class="inner">
                        <h3><?= $info->total; ?></h3>
                        <p><?= $info->title; ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-<?= $info->icon ?>"></i>
                    </div>
                    <a href="<?= base_url() . strtolower($info->title); ?>" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php elseif ($this->ion_auth->in_group('dosen')) : ?>

    <div class="row">
        <div class="col-sm-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Informasi Akun</h3>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>Nama</th>
                        <td><?= $dosen->nama_pengajar ?></td>
                    </tr>
                    <tr>
                        <th>NIP</th>
                        <td><?= $dosen->nip ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $dosen->email ?></td>
                    </tr>
                    <tr>
                        <th>Skema LSP</th>
                        <td><?= $dosen->nama_klsp ?></td>
                    </tr>
                    <tr>
                        <th>Daftar Skema</th>
                        <td>
                            <ol class="pl-4">
                                <?php foreach ($skema as $k) : ?>
                                    <li><?= $k->nama_skema ?></li>
                                <?php endforeach; ?>
                            </ol>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="box box-solid">
                <div class="box-header bg-purple">
                    <h3 class="box-title">Pemberitahuan</h3>
                </div>
                <div class="box-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quidem in animi quibusdam nihil esse ratione, nulla sint enim natus, aut mollitia quas veniam, tempore quia!</p>
                    <ul class="pl-4">
                        <li>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consectetur, culpa.</li>
                        <li>Provident dolores doloribus, fugit aperiam alias tempora saepe non omnis.</li>
                        <li>Doloribus sed eum et repellat distinctio a repudiandae quia voluptates.</li>
                        <li>Adipisci hic rerum illum odit possimus voluptatibus ad aliquid consequatur.</li>
                        <li>Laudantium sapiente architecto excepturi beatae est minus, labore non libero.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php else : ?>

    <div class="row">
        <div class="col-sm-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Informasi Akun</h3>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>NIM</th>
                        <td><?= $mahasiswa->nim ?></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><?= $mahasiswa->nama ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td><?= $mahasiswa->jenis_kelamin === 'L' ? "Laki-laki" : "Perempuan"; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $mahasiswa->email ?></td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td><?= $mahasiswa->nama_level ?></td>
                    </tr>
                    <tr>
                        <th>Skema</th>
                        <td><?= $mahasiswa->nama_skema ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="box box-solid">
                <div class="box-header bg-purple">
                    <h3 class="box-title">Pemberitahuan</h3>
                </div>
                <div class="box-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quidem in animi quibusdam nihil esse ratione, nulla sint enim natus, aut mollitia quas veniam, tempore quia!</p>
                    <ul class="pl-4">
                        <li>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consectetur, culpa.</li>
                        <li>Provident dolores doloribus, fugit aperiam alias tempora saepe non omnis.</li>
                        <li>Doloribus sed eum et repellat distinctio a repudiandae quia voluptates.</li>
                        <li>Adipisci hic rerum illum odit possimus voluptatibus ad aliquid consequatur.</li>
                        <li>Laudantium sapiente architecto excepturi beatae est minus, labore non libero.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>