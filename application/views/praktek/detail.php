<div class="box">
    <div class="box-header with-header">
        <h3 class="box-title">Detail praktek</h3>
        <div class="pull-right">
            <a href="<?= base_url() ?>praktek" class="btn btn-xs btn-flat btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <a href="<?= base_url() ?>praktek/edit/<?= $this->uri->segment(3) ?>" class="btn btn-xs btn-flat btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h3 class="text-center">Soal Praktek</h3>
                <?php if (!empty($praktek->file)) : ?>
                    <div class="w-50">
                        <?= tampil_media('uploads/bank_soal/' . $praktek->file); ?>
                    </div>
                <?php endif; ?>
                <?= $praktek->soal ?>
                <hr class="my-4">

                <?php
                $benar = "<i class='fa fa-check-circle text-purple'></i>";


                $jawaban = 'jawaban';
                $file = 'file';
                ?>

                <?= $praktek->$jawaban ?>

                <?php if (!empty($praktek->$file)) : ?>
                    <div class="w-50 mx-auto">
                        <?= tampil_media('uploads/bank_praktek/' . $praktek->$file); ?>
                    </div>
                <?php endif; ?>


                <hr class="my-4">
                <strong>Dibuat pada :</strong> <?= strftime("%A, %d %B %Y", date($praktek->created_on)) ?>
                <br>
                <strong>Terkahir diupdate :</strong> <?= strftime("%A, %d %B %Y", date($praktek->updated_on)) ?>
            </div>
        </div>
    </div>
</div>