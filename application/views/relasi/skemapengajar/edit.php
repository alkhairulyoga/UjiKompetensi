<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form <?= $judul ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url() ?>skemapengajar" class="btn btn-warning btn-flat btn-sm">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <?= form_open('skemapengajar/save', array('id' => 'skemapengajar'), array('method' => 'edit', 'pengajar_id' => $id_pengajar)) ?>
                <div class="form-group">
                    <label>Pengajar</label>
                    <input type="text" readonly="readonly" value="<?= $pengajar->nama_pengajar ?>" class="form-control">
                    <small class="help-block text-right"></small>
                </div>
                <div class="form-group">
                    <label>Skema</label>
                    <select id="skema" multiple="multiple" name="skema_id[]" class="form-control select2" style="width: 100%!important">
                        <?php
                        $sk = [];
                        foreach ($skema as $key => $val) {
                            $sk[] = $val->id_skema;
                        }
                        foreach ($all_skema as $m) : ?>
                            <option <?= in_array($m->id_skema, $sk) ? "selected" : "" ?> value="<?= $m->id_skema ?>"><?= $m->nama_skema ?> - <?= $m->nama_level ?></option>
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

<script src="<?= base_url() ?>assets/dist/js/app/relasi/skemapengajar/edit.js"></script>