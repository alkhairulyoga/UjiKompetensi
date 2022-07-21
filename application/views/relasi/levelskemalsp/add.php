<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form <?= $judul ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url() ?>levelskemalsp" class="btn btn-warning btn-flat btn-sm">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="alert bg-purple">
                    <h4><i class="fa fa-info-circle"></i> Informasi</h4>
                    Jika kolom Skema LSP kosong, berikut ini kemungkinan penyebabnya :
                    <br><br>
                    <ol class="pl-4">
                        <li>Anda belum menambahkan master data Skema LSP (Master Skema LSP kosong/belum ada data sama sekali).</li>
                        <li>Skema LSP sudah ditambahkan, jadi anda tidak perlu tambah lagi. Anda hanya perlu mengedit data Level Skema LSP nya saja.</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-4">
                <?= form_open('levelskemalsp/save', array('id' => 'levelskemalsp'), array('method' => 'add')) ?>
                <div class="form-group">
                    <label>Skema LSP</label>
                    <select name="klsp_id" class="form-control select2" style="width: 100%!important">
                        <option value="" disabled selected></option>
                        <?php foreach ($klsp as $m) : ?>
                            <option value="<?= $m->id_klsp ?>"><?= $m->nama_klsp ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="help-block text-right"></small>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select id="level" multiple="multiple" name="level_id[]" class="form-control select2" style="width: 100%!important">
                    </select>
                    <small class="help-block text-right"></small>
                </div>
                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-flat btn-default">
                        <i class="fa fa-rotate-left"></i> Reset
                    </button>
                    <button id="submit" type="submit" class="btn btn-flat bg-purple">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/dist/js/app/relasi/levelskemalsp/add.js"></script>