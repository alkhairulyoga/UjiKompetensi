<?= form_open('pengajar/save', array('id' => 'formpengajar'), array('method' => 'edit', 'id_pengajar' => $data->id_pengajar)); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form <?= $subjudul ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url() ?>pengajar" class="btn btn-sm btn-flat btn-warning">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input value="<?= $data->nip ?>" autofocus="autofocus" onfocus="this.select()" type="number" id="nip" class="form-control" name="nip" placeholder="NIP">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="nama_pengajar">Nama Pengajar</label>
                    <input value="<?= $data->nama_pengajar ?>" type="text" class="form-control" name="nama_pengajar" placeholder="Nama Pengajar">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="email">Email Pengajar</label>
                    <input value="<?= $data->email ?>" type="text" class="form-control" name="email" placeholder="Email Pengajar">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="klsp">Skema LSP</label>
                    <select name="klsp" id="klsp" class="form-control select2" style="width: 100%!important">
                        <option value="" disabled selected>Pilih Skema LSP</option>
                        <?php foreach ($klsp as $row) : ?>
                            <option <?= $data->klsp_id === $row->id_klsp ? "selected" : "" ?> value="<?= $row->id_klsp ?>"><?= $row->nama_klsp ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-flat btn-default">
                        <i class="fa fa-rotate-left"></i> Reset
                    </button>
                    <button type="submit" id="submit" class="btn btn-flat bg-purple">
                        <i class="fa fa-pencil"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>

<script src="<?= base_url() ?>assets/dist/js/app/master/pengajar/edit.js"></script>