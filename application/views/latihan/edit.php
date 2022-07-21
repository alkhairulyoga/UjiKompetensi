<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('latihan/save', array('id' => 'formlatihan'), array('method' => 'edit', 'id_soal' => $latihan->id_soal)); ?>
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
                                        $sdm = $latihan->pengajar_id . ':' . $latihan->klsp_id;
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
                                <label for="soal" class="control-label text-center">soal</label>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <input type="file" name="file_soal" class="form-control">
                                        <small class="help-block" style="color: #dc3545"><?= form_error('file_soal') ?></small>
                                        <?php if (!empty($latihan->file)) : ?>
                                            <?= tampil_media('uploads/bank_soal/' . $latihan->file); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-sm-9">
                                        <textarea name="soal" id="soal" class="form-control summernote"><?= $latihan->soal ?></textarea>
                                        <small class="help-block" style="color: #dc3545"><?= form_error('latihan') ?></small>
                                    </div>
                                </div>
                            </div>

                            <!-- 
                                Membuat perulangan A-E 
                            -->
                            <?php
                            $abjad = ['a', 'b', 'c', 'd', 'e'];
                            foreach ($abjad as $abj) :
                                $ABJ = strtoupper($abj); // Abjad Kapital
                                $file = 'file_' . $abj;
                                $opsi = 'opsi_' . $abj;
                            ?>

                                <div class="col-sm-12">
                                    <label for="jawaban_<?= $abj; ?>" class="control-label text-center">Jawaban <?= $ABJ; ?></label>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <input type="file" name="<?= $file; ?>" class="form-control">
                                            <small class="help-block" style="color: #dc3545"><?= form_error($file) ?></small>
                                            <?php if (!empty($latihan->$file)) : ?>
                                                <?= tampil_media('uploads/bank_soal/' . $latihan->$file); ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group col-sm-9">
                                            <textarea name="jawaban_<?= $abj; ?>" id="jawaban_<?= $abj; ?>" class="form-control summernote"><?= $latihan->$opsi ?></textarea>
                                            <small class="help-block" style="color: #dc3545"><?= form_error('jawaban_' . $abj) ?></small>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                            <div class="form-group col-sm-12">
                                <label for="jawaban" class="control-label">Kunci Jawaban</label>
                                <select required="required" name="jawaban" id="jawaban" class="form-control select2" style="width:100%!important">
                                    <option value="" disabled selected>Pilih Kunci Jawaban</option>
                                    <option <?= $latihan->jawaban === "A" ? "selected" : "" ?> value="A">A</option>
                                    <option <?= $latihan->jawaban === "B" ? "selected" : "" ?> value="B">B</option>
                                    <option <?= $latihan->jawaban === "C" ? "selected" : "" ?> value="C">C</option>
                                    <option <?= $latihan->jawaban === "D" ? "selected" : "" ?> value="D">D</option>
                                    <option <?= $latihan->jawaban === "E" ? "selected" : "" ?> value="E">E</option>
                                </select>
                                <small class="help-block" style="color: #dc3545"><?= form_error('jawaban') ?></small>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="bobot" class="control-label">Bobot Nilai</label>
                                <input required="required" value="<?= $latihan->bobot ?>" type="number" name="bobot" placeholder="Bobot latihan" id="bobot" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?= form_error('bobot') ?></small>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="<?= base_url('latihan') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
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