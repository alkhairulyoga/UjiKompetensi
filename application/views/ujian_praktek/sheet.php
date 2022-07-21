<?php
if (time() >= $soal->waktu_habis) {
    redirect('ujian_praktek/list', 'location', 301);
}
?>

<?= form_open_multipart('ujian_praktek/simpan_akhir', array('id' => 'formujian_praktek'), array('method' => 'add')); ?>



<div class="row">
    <div class="col-sm-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Navigasi Soal</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body text-center" id="tampil_jawaban">
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <?= form_open('', array('id' => 'ujian_praktek'), array('id' => $id_tes)); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><span class="badge bg-blue">Soal #<span id="soalke"></span> </span></h3>
                <div class="box-tools pull-right">
                    <span class="badge bg-red">Sisa Waktu <span class="sisawaktu" data-time="<?= $soal->tgl_selesai ?>"></span></span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <input type="file" name="opsi_" class="form-control">
                <small class="help-block" style="color: #dc3545"><?= form_error('opsi_') ?></small>
            </div>

            <div class="box-body">
                <?= $html ?>
            </div>
            <div class="box-footer text-center">
                <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                <input type="hidden" name="jml_soal" id="jml_soal" value="<?= $no; ?>">
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    var base_url = "<?= base_url(); ?>";
    var id_tes = "<?= $id_tes; ?>";
    var widget = $(".step");
    var total_widget = widget.length;
</script>


<script type="text/javascript">
    $(document).ready(function() {

        $('#simpan_akhir').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/upload/do_upload',
                type: "post",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function(data) {
                    alert("Upload Image Berhasil.");
                }
            });
        });


    });
</script>