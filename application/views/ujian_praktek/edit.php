<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $subjudul ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url() ?>ujian_praktek/master" class="btn btn-sm btn-flat btn-warning">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="alert bg-purple">
                    <h4>Skema LSP <i class="fa fa-book pull-right"></i></h4>
                    <p><?= $skemalsp->nama_klsp ?></p>
                </div>
                <div class="alert bg-purple">
                    <h4>Pengajar <i class="fa fa-address-book-o pull-right"></i></h4>
                    <p><?= $dosen->nama_pengajar ?></p>
                </div>
            </div>
            <div class="col-sm-4">
                <?= form_open('ujian_praktek/save', array('id' => 'formujian_praktek'), array('method' => 'edit', 'dosen_id' => $dosen->id_pengajar, 'skemalsp_id' => $skemalsp->klsp_id, 'id_praktek' => $ujianpraktek->id_praktek)) ?>
                <div class="form-group">
                    <label for="nama_praktek">Nama ujianpraktek</label>
                    <input value="<?= $ujianpraktek->nama_praktek ?>" autofocus="autofocus" onfocus="this.select()" placeholder="Nama ujianpraktek" type="text" class="form-control" name="nama_praktek">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="jumlah_soal">Jumlah Soal</label>
                    <input value="<?= $ujianpraktek->jumlah_soal ?>" placeholder="Jumlah Soal" type="number" class="form-control" name="jumlah_soal">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="tgl_mulai">Tanggal Mulai</label>
                    <input id="tgl_mulai" name="tgl_mulai" type="text" class="datetimepicker form-control" placeholder="Tanggal Mulai">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="tgl_selesai">Tanggal Selesai</label>
                    <input id="tgl_selesai" name="tgl_selesai" type="text" class="datetimepicker form-control" placeholder="Tanggal Selesai">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="waktu">Waktu</label>
                    <input value="<?= $ujianpraktek->waktu ?>" placeholder="menit" type="number" class="form-control" name="waktu">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="jenis">Acak Soal</label>
                    <select name="jenis" class="form-control">
                        <option value="" disabled selected>--- Pilih ---</option>
                        <option <?= $ujianpraktek->jenis === "acak" ? "selected" : ""; ?> value="acak">Acak Soal</option>
                        <option <?= $ujianpraktek->jenis === "urut" ? "selected" : ""; ?> value="urut">Urut Soal</option>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-default btn-flat">
                        <i class="fa fa-rotate-left"></i> Reset
                    </button>
                    <button id="submit" type="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var tgl_mulai = '<?= $ujianpraktek->tgl_mulai ?>';
    var terlambat = '<?= $ujianpraktek->terlambat ?>';
</script>

<script src="<?= base_url() ?>assets/dist/js/app/ujian_praktek/edit.js"></script>