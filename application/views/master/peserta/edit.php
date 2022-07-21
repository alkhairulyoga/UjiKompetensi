<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form <?= $judul ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url('peserta') ?>" class="btn btn-sm btn-flat btn-warning">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <?= form_open('peserta/save', array('id' => 'peserta'), array('method' => 'edit', 'id_mahasiswa' => $peserta->id_mahasiswa)) ?>
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input value="<?= $peserta->nim ?>" autofocus="autofocus" onfocus="this.select()" placeholder="NIM" type="text" name="nim" class="form-control">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input value="<?= $peserta->nama ?>" placeholder="Nama" type="text" name="nama" class="form-control">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input value="<?= $peserta->email ?>" placeholder="Email" type="email" name="email" class="form-control">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control select2">
                        <option value="">-- Pilih --</option>
                        <option <?= $peserta->jenis_kelamin === "L" ? "selected" : "" ?> value="L">Laki-laki</option>
                        <option <?= $peserta->jenis_kelamin === "P" ? "selected" : "" ?> value="P">Perempuan</option>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="klsp">Skema LSP</label>
                    <select id="klsp" name="klsp" class="form-control select2">
                        <option value="" disabled selected>-- Pilih --</option>
                        <?php foreach ($klsp as $j) : ?>
                            <option <?= $peserta->id_level === $j->id_klsp ? "selected" : "" ?> value="<?= $j->id_klsp ?>">
                                <?= $j->nama_klsp ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="skema">Skema</label>
                    <select id="skema" name="skema" class="form-control select2">
                        <option value="" disabled selected>-- Pilih --</option>
                        <?php foreach ($skema as $k) : ?>
                            <option <?= $peserta->id_skema === $k->id_skema ? "selected" : "" ?> value="<?= $k->id_skema ?>">
                                <?= $k->nama_skema ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-flat btn-default"><i class="fa fa-rotate-left"></i> Reset</button>
                    <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/dist/js/app/master/peserta/edit.js"></script>