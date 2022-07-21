<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('praktek/save', array('id' => 'formpraktek'), array('method' => 'add')); ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $subjudul ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group col-sm-12">
                            <label>pengajar (Skema LSP)</label>
                            <?php if ($this->ion_auth->is_admin()) : ?>
                                <select name="pengajar_id" required="required" id="pengajar_id" class="select2 form-group" style="width:100% !important">
                                    <option value="" disabled selected>Pilih Pengajar</option>
                                    <?php foreach ($pengajar as $d) : ?>
                                        <option value="<?= $d->id_pengajar ?>:<?= $d->klsp_id ?>"><?= $d->nama_pengajar ?> (<?= $d->nama_klsp ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="help-block" style="color: #dc3545"><?= form_error('pengajar_id') ?></small>
                            <?php else : ?>
                                <input type="hidden" name="pengajar_id" value="<?= $pengajar->id_pengajar; ?>">
                                <input type="hidden" name="klsp_id" value="<?= $pengajar->klsp_id; ?>">
                                <input type="text" readonly="readonly" class="form-control" value="<?= $pengajar->nama_pengajar; ?> (<?= $pengajar->nama_klsp; ?>)">
                            <?php endif; ?>
                        </div>

                        <div class="col-sm-12">
                            <label for="praktek" class="control-label">Soal Praktek</label>
                            <div class="form-group">
                                <input type="file" name="file_praktek" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?= form_error('file_praktek') ?></small>
                            </div>
                            <div class="form-group">
                                <textarea name="soal" id="soal" class="form-control summernote"><?= set_value('soal') ?></textarea>
                                <small class="help-block" style="color: #dc3545"><?= form_error('soal') ?></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label for="file">Deskripsi</label>
                            <div class="form-group">
                                <textarea name="jawaban" id="jawaban" class="form-control summernote"><?= set_value('jawaban') ?></textarea>
                                <small class="help-block" style="color: #dc3545"><?= form_error('jawaban') ?></small>
                            </div>
                        </div>

                        <div class="form-group pull-right">
                            <a href="<?= base_url('praktek') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                            <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>