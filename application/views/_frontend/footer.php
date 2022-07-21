</main>
</body>
<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="<?= base_url() ?>assets/frontend/vendor/apexcharts/apexcharts.min.js"></script>
<script src="<?= base_url() ?>assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/frontend/vendor/chart.js/chart.min.js"></script>
<script src="<?= base_url() ?>assets/frontend/vendor/echarts/echarts.min.js"></script>
<script src="<?= base_url() ?>assets/frontend/vendor/quill/quill.min.js"></script>
<script src="<?= base_url() ?>assets/frontend/vendor/tinymce/tinymce.min.js"></script>
<script src="<?= base_url() ?>assets/frontend/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="<?= base_url() ?>assets/frontend/js/main.js"></script>

<!-- Required JS -->
<script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- Datatables Buttons -->
<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/plugins/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/plugins/Buttons-1.5.6/js/buttons.bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/plugins/JSZip-2.5.0/jszip.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/plugins/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/plugins/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/plugins/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/plugins/Buttons-1.5.6/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/plugins/Buttons-1.5.6/js/buttons.colVis.min.js"></script>

<script src="<?= base_url() ?>assets/bower_components/pace/pace.min.js"></script>
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>

<!-- Textarea editor -->
<script src="<?= base_url() ?>assets/bower_components/codemirror/lib/codemirror.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/codemirror/mode/xml.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/froala_editor/js/froala_editor.pkgd.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<!-- App JS -->
<script src="<?= base_url() ?>assets/dist/js/app/dashboard.js"></script>

<!-- Custom JS -->
<script type="text/javascript">
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };

    function ajaxcsrf() {
        var csrfname = '<?= $this->security->get_csrf_token_name() ?>';
        var csrfhash = '<?= $this->security->get_csrf_hash() ?>';
        var csrf = {};
        csrf[csrfname] = csrfhash;
        $.ajaxSetup({
            "data": csrf
        });
    }

    function reload_ajax() {
        table.ajax.reload(null, false);
    }

    $(document).ready(function() {
        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    });
</script>




</html>