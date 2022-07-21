<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('modul/save', array('id' => 'formmodul'), array('method' => 'edit', 'id_modul' => $modul->id_modul)); ?>
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
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="pengajar_id" class="control-label">Pengajar (Skema LSP)</label>
                                <?php if ($this->ion_auth->is_admin()) : ?>
                                    <select required="required" name="pengajar_id" id="pengajar_id" class="select2 form-group" style="width:100% !important">
                                        <option value="" disabled selected>Pilih Pengajar</option>
                                        <?php
                                        $sdm = $modul->pengajar_id . ':' . $modul->klsp_id;
                                        foreach ($pengajar as $d) :
                                            $dm = $d->id_pengajar . ':' . $d->klsp_id; ?>
                                            <option <?= $sdm === $dm ? "selected" : ""; ?> value="<?= $dm ?>"><?= $d->nama_pengajar ?> (<?= $d->nama_klsp ?>)</option>
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
                                <label for="modul" class="control-label text-center">modul</label>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <input type="file" name="file_modul" class="form-control">
                                        <small class="help-block" style="color: #dc3545"><?= form_error('file_modul') ?></small>
                                        <?php if (!empty($modul->file)) : ?>
                                            <?= tampil_media('uploads/bank_soal/' . $modul->file); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-sm-9">
                                        <textarea name="modul" id="modul" class="form-control summernote"><?= $modul->modul ?></textarea>
                                        <small class="help-block" style="color: #dc3545"><?= form_error('modul') ?></small>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-12">
                                <label for="deskripsi class=" control-label text-center">deskripsi</label>
                                <div class="row">
                                    <div class="form-group col-sm-9">
                                        <textarea name="deskripsi" id=" deskripsi" class="form-control summernote"><?= $modul->deskripsi ?></textarea>
                                        <small class="help-block" style="color: #dc3545"><?= form_error('deskripsi') ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="<?= base_url('modul') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                                    <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>