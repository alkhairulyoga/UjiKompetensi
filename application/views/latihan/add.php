<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('latihan/save', array('id' => 'formlatihan'), array('method' => 'add')); ?>
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
                            <label>Pengajar (Skema LSP)</label>
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

                        <div class="form-group col-sm-12">
                            <label for="modul_id">Nama Modul</label>
                            <select name="modul_id" id="modul_id" class="form-control select2" style="width: 100%!important">
                                <option value="" disabled selected>Pilih modul</option>
                                <?php foreach ($modul as $row) : ?>
                                    <option value="<?= $row->id_modul ?>"><?= $row->modul ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="help-block"></small>
                        </div>



                        <div class="col-sm-12">
                            <label for="soal" class="control-label">Soal</label>
                            <div class="form-group">
                                <input type="file" name="file_soal" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?= form_error('file_soal') ?></small>
                            </div>
                            <div class="form-group">
                                <textarea name="soal" id="soal" class="form-control summernote"><?= set_value('soal') ?></textarea>
                                <small class="help-block" style="color: #dc3545"><?= form_error('soal') ?></small>
                            </div>
                        </div>

                        <!-- 
                            Membuat perulangan A-E 
                        -->
                        <?php
                        $abjad = ['a', 'b', 'c', 'd', 'e'];
                        foreach ($abjad as $abj) :
                            $ABJ = strtoupper($abj); // Abjad Kapital
                        ?>

                            <div class="col-sm-12">
                                <label for="file">Jawaban <?= $ABJ; ?></label>
                                <div class="form-group">
                                    <input type="file" name="file_<?= $abj; ?>" class="form-control">
                                    <small class="help-block" style="color: #dc3545"><?= form_error('file_' . $abj) ?></small>
                                </div>
                                <div class="form-group">
                                    <textarea name="jawaban_<?= $abj; ?>" id="jawaban_<?= $abj; ?>" class="form-control summernote"><?= set_value('jawaban_a') ?></textarea>
                                    <small class="help-block" style="color: #dc3545"><?= form_error('jawaban_' . $abj) ?></small>
                                </div>
                            </div>

                        <?php endforeach; ?>

                        <div class="form-group col-sm-12">
                            <label for="jawaban" class="control-label">Kunci Jawaban</label>
                            <select required="required" name="jawaban" id="jawaban" class="form-control select2" style="width:100%!important">
                                <option value="" disabled selected>Pilih Kunci Jawaban</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                            <small class="help-block" style="color: #dc3545"><?= form_error('jawaban') ?></small>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="bobot" class="control-label">Bobot Soal</label>
                            <input required="required" value="1" type="number" name="bobot" placeholder="Bobot Soal" id="bobot" class="form-control">
                            <small class="help-block" style="color: #dc3545"><?= form_error('bobot') ?></small>
                        </div>
                        <div class="form-group pull-right">
                            <a href="<?= base_url('latihan') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                            <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>