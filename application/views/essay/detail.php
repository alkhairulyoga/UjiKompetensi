<div class="box">
    <div class="box-header with-header">
        <h3 class="box-title">Detail essay</h3>
        <div class="pull-right">
            <a href="<?= base_url() ?>essay" class="btn btn-xs btn-flat btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <a href="<?= base_url() ?>essay/edit/<?= $this->uri->segment(3) ?>" class="btn btn-xs btn-flat btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h3 class="text-center">Soal Essay</h3>
                <?php if (!empty($essay->file)) : ?>
                    <div class="w-50">
                        <?= tampil_media('uploads/bank_soal/' . $essay->file); ?>
                    </div>
                <?php endif; ?>
                <?= $essay->soal ?>
                <hr class="my-4">
                <h3 class="text-center">Jawaban</h3>

                <?php
                $benar = "<i class='fa fa-check-circle text-purple'></i>";


                $jawaban = 'jawaban';
                $file = 'file';
                ?>

                <h4>Kunci Jawaban <?= $essay->jawaban === $benar ?></h4>
                <?= $essay->$jawaban ?>

                <?php if (!empty($essay->$file)) : ?>
                    <div class="w-50 mx-auto">
                        <?= tampil_media('uploads/bank_essay/' . $essay->$file); ?>
                    </div>
                <?php endif; ?>


                <hr class="my-4">
                <strong>Dibuat pada :</strong> <?= strftime("%A, %d %B %Y", date($essay->created_on)) ?>
                <br>
                <strong>Terkahir diupdate :</strong> <?= strftime("%A, %d %B %Y", date($essay->updated_on)) ?>
            </div>
        </div>
    </div>
</div>