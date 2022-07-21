<div class="box">
    <div class="box-header with-header">
        <h3 class="box-title">Detail latihan</h3>
        <div class="pull-right">
            <a href="<?= base_url() ?>latihan" class="btn btn-xs btn-flat btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <a href="<?= base_url() ?>latihan/edit/<?= $this->uri->segment(3) ?>" class="btn btn-xs btn-flat btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h3 class="text-center">Latihan</h3>
                <?php if (!empty($latihan->file)) : ?>
                    <div class="w-50">
                        <?= tampil_media('uploads/bank_soal/' . $latihan->file); ?>
                    </div>
                <?php endif; ?>
                <?= $latihan->soal ?>
                <hr class="my-4">
                <h3 class="text-center">Jawaban</h3>

                <?php
                $abjad = ['a', 'b', 'c', 'd', 'e'];
                $benar = "<i class='fa fa-check-circle text-purple'></i>";

                foreach ($abjad as $abj) :

                    $ABJ = strtoupper($abj);
                    $opsi = 'opsi_' . $abj;
                    $file = 'file_' . $abj;
                ?>

                    <h4>Pilihan <?= $ABJ ?> <?= $latihan->jawaban === $ABJ ? $benar : "" ?></h4>
                    <?= $latihan->$opsi ?>

                    <?php if (!empty($latihan->$file)) : ?>
                        <div class="w-50 mx-auto">
                            <?= tampil_media('uploads/bank_latihan/' . $latihan->$file); ?>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>

                <hr class="my-4">
                <strong>Dibuat pada :</strong> <?= strftime("%A, %d %B %Y", date($latihan->created_on)) ?>
                <br>
                <strong>Terkahir diupdate :</strong> <?= strftime("%A, %d %B %Y", date($latihan->updated_on)) ?>
            </div>
        </div>
    </div>
</div>