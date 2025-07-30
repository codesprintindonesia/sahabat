<script src="<?= base_url() ?>public/js/jquery.js"></script>
<script src="<?= base_url() ?>public/js/plugins.min.js"></script>
<script src="<?= base_url() ?>public/js/functions.bundle.js"></script>
<script>
    // Tampilkan loading saat permintaan AJAX dimulai
    $(document).ajaxStart(function() {
        $('#preloader').show();
    });

    // Sembunyikan loading saat permintaan AJAX selesai
    $(document).ajaxStop(function() {
        $('#preloader').hide();
    });
</script>