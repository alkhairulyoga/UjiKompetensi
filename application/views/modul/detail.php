<div class="box">
    <div class="box-header with-header">
        <h3 class="box-title">Detail modul</h3>
        <div class="pull-right">
            <a href="<?= base_url() ?>modul/list" class="btn btn-xs btn-flat btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h3 class="text-center">Modul</h3>
                <?php if (!empty($modul->file)) : ?>
                    <div class="w-500">
                        <?= tampil_media('uploads/bank_soal/' . $modul->file); ?>
                    </div>
                <?php endif; ?>
                <?= $modul->modul ?>
                <hr class="my-4">


                <hr class="my-4">
                <strong>Dibuat pada :</strong> <?= strftime("%A, %d %B %Y", date($modul->created_on)) ?>
                <br>
                <strong>Terkahir diupdate :</strong> <?= strftime("%A, %d %B %Y", date($modul->updated_on)) ?>
            </div>
        </div>
    </div>
</div>