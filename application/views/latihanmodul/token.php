<div class="callout callout-info">
    <h4>Peraturan latihanmodul!</h4>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime minus dolores accusantium fugiat debitis modi voluptates non consequuntur nemo expedita nihil laudantium commodi voluptatum voluptatem molestiae consectetur incidunt animi, qui exercitationem? Nisi illo, magnam perferendis commodi consequuntur impedit, et nihil excepturi quas iste cum sunt debitis odio beatae placeat nemo..</p>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Konfirmasi Data</h3>
    </div>
    <div class="box-body">
        <span id="id_latihan" data-key="<?= $encrypted_id ?>"></span>
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama</th>
                        <td><?= $mhs->nama ?></td>
                    </tr>
                    <tr>
                        <th>Pengajar</th>
                        <td><?= $latihanmodul->nama_pengajar ?></td>
                    </tr>
                    <tr>
                        <th>Skema/Level</th>
                        <td><?= $mhs->nama_skema ?> / <?= $mhs->nama_level ?></td>
                    </tr>
                    <tr>
                        <th>Nama latihanmodul</th>
                        <td><?= $latihanmodul->nama_latihan ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Soal</th>
                        <td><?= $latihanmodul->jumlah_soal ?></td>
                    </tr>
                    <tr>
                        <th>Waktu</th>
                        <td><?= $latihanmodul->waktu ?> Menit</td>
                    </tr>
                    <tr>
                        <th>Terlambat</th>
                        <td>
                            <?= strftime('%d %B %Y', strtotime($latihanmodul->terlambat)) ?>
                            <?= date('H:i:s', strtotime($latihanmodul->terlambat)) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input autocomplete="off" id="token" type="text" class="input-sm form-control hidden">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <div class="box box-solid">
                    <div class="box-body pb-0">
                        <div class="callout callout-info">
                            <p>
                                Waktu boleh mengerjakan latihanmodul adalah saat tombol "MULAI" berwarna hijau.
                            </p>
                        </div>
                        <?php
                        $mulai = strtotime($latihanmodul->tgl_mulai);
                        $terlambat = strtotime($latihanmodul->terlambat);
                        $now = time();
                        if ($mulai > $now) :
                        ?>
                            <div class="callout callout-success">
                                <strong><i class="fa fa-clock-o"></i> latihanmodul akan dimulai pada</strong>
                                <br>
                                <span class="countdown" data-time="<?= date('Y-m-d H:i:s', strtotime($latihanmodul->tgl_mulai)) ?>">00 Hari, 00 Jam, 00 Menit, 00 Detik</strong><br />
                            </div>
                        <?php elseif ($terlambat > $now) : ?>
                            <button id="btncek" data-id="<?= $latihanmodul->id_latihan ?>" class="btn btn-success btn-lg mb-4">
                                <i class="fa fa-pencil"></i> Mulai
                            </button>
                            <div class="callout callout-danger">
                                <i class="fa fa-clock-o"></i> <strong class="countdown" data-time="<?= date('Y-m-d H:i:s', strtotime($latihanmodul->terlambat)) ?>">00 Hari, 00 Jam, 00 Menit, 00 Detik</strong><br />
                                Batas waktu menekan tombol mulai.
                            </div>
                        <?php else : ?>
                            <div class="callout callout-danger">
                                Waktu untuk menekan tombol <strong>"MULAI"</strong> sudah habis.<br />
                                Silahkan hubungi dosen anda untuk bisa mengikuti latihanmodul pengganti.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/dist/js/app/latihanmodul/token.js"></script>