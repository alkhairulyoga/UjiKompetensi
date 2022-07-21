<div class="box box-primary">
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
            <div class="col-sm-4 col-sm-offset-4">
                <?= form_open('levelskemalsp/save', array('id' => 'levelskemalsp'), array('method' => 'edit', 'klsp_id' => $id_klsp)) ?>
                <div class="form-group">
                    <label>Skema LSP</label>
                    <input type="text" readonly="readonly" value="<?= $klsp->nama_klsp ?>" class="form-control">
                    <small class="help-block text-right"></small>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select id="level" multiple="multiple" name="level_id[]" class="form-control select2" style="width: 100%!important">
                        <?php
                        $sj = [];
                        foreach ($level as $key => $val) {
                            $sj[] = $val->id_level;
                        }
                        foreach ($all_level as $m) : ?>
                            <option <?= in_array($m->id_level, $sj) ? "selected" : "" ?> value="<?= $m->id_level ?>"><?= $m->nama_level ?></option>
                        <?php endforeach; ?>
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

<script src="<?= base_url() ?>assets/dist/js/app/relasi/levelskemalsp/edit.js"></script>