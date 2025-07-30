<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="author" content="Disperindag Provinsi Sultra | Sahabat Agro">
    <meta name="description" content="Hubungi kami di Sahabat Agro untuk pertanyaan, saran, atau kerja sama. Kami siap membantu Anda dalam mengembangkan sektor pertanian dan agroindustri.">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Tambahkan meta tag lainnya sesuai kebutuhan -->

    <!-- Contoh meta tag untuk SEO -->
    <meta name="keywords" content="pertanian, agroindustri, perdagangan, industri, kesejahteraan, Dinas Perindustrian dan Perdagangan">

    <!-- Contoh meta tag untuk sosial media -->
    <meta property="og:title" content="<?= $title ?>">
    <meta property="og:description" content="Hubungi kami di Sahabat Agro untuk pertanyaan, saran, atau kerja sama. Kami siap membantu Anda dalam mengembangkan sektor pertanian dan agroindustri.">
    <meta property="og:image" content="<?= base_url() ?>public/images/logo-daun-kecil.png">
    <meta property="og:url" content="<?= base_url() ?>">

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url() ?>public/images/logo-daun-kecil.ico" type="image/x-icon">

    <!-- Stylesheets
    ============================================= -->
    <?= $this->include('partials/css') ?>

    <!-- Document Title
	============================================= -->
    <title><?= $title ?></title>

    <style> 

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            /* Hitam semi-transparan */
            z-index: 0;
        }
    </style>

</head>

<body class="stretched">

    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper">
        <!-- Header
		============================================= -->
        <?= $this->include('partials/user_header') ?>
        <!-- #header end -->

        <!-- Content
		============================================= -->
        <section id="content" class="slider-element py-6 block-hero-6" style="background: url('<?= base_url() ?>public/images/background.jpg') center center no-repeat; background-size: cover;">
            <!-- Overlay untuk efek gelap dan buram -->
            <div class="overlay"></div>
            <div class="content-wrap py-0">
                <div class="container mw-lg">
                    <div class="row flex-md-row-reverse justify-content-between align-items-center">
                        <div class="col-lg-6">
                            <h5 class="ls-3 fw-normal  op-04 mb-2 text-uppercase" style="color: #fff">Kontak</h5>
                            <h3 class="mb-4 display-4 text-transform-none ls-0 fw-semibold" style="color: #fff">Hubungi Kami</h3>
                            <p class="mw-xs lead op-07 mb-5" style="color: #fff">untuk pertanyaan, saran, atau kerja sama. Kami siap membantu Anda dalam mengembangkan sektor pertanian dan agroindustri.</p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="feature-box fbox-sm mb-4">
                                        <div class="fbox-icon">
                                            <i class="bi-geo-alt"></i>
                                        </div>
                                        <div class="fbox-content">
                                            <h4 class="text-transform-none font-body fw-normal mb-2" style="color: #1abc9c">
                                                Jl. H. Abdul Silondae No.116, <br>
                                                Kota Kendari, Sulawesi Tenggara
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="feature-box fbox-sm mb-4">
                                        <div class="fbox-icon">
                                            <i class="bi-telephone-outbound"></i>
                                        </div>
                                        <div class="fbox-content">
                                            <h4 class="text-transform-none font-body fw-normal mb-2" style="color: #fff"><a href="tel:+6285211111111">(62)85211111111</a></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="feature-box fbox-sm mb-4">
                                        <div class="fbox-icon">
                                            <i class="bi-envelope"></i>
                                        </div>
                                        <div class="fbox-content">
                                            <h4 class="text-transform-none font-body fw-normal mb-2" style="color: #fff"><a href="mailto:sahabatagro@gmail.com">sahabatagro@gmail.com</a></h4>
                                        </div>
                                    </div>
                                    <div class="feature-box fbox-sm">
                                        <div class="fbox-icon">
                                            <i class="bi-clock"></i>
                                        </div>
                                        <div class="fbox-content">
                                            <h4 class="text-transform-none font-body fw-normal mb-2" style="color: #1abc9c">Senin-Jumat <br>07:30-16:00 WITA</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 mt-5 mt-lg-0">
                            <div class="card border-0 p-4">
                                <div class="card-body py-4">
                                    <div class="form-widget">

                                        <div class="form-result"></div>

                                        <form class="mb-0" id="template-contactform" name="template-contactform">
                                            <div class="form-process">
                                                <div class="css3-spinner">
                                                    <div class="css3-spinner-scaler"></div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 form-group mb-4">
                                                    <label class="color" for="template-contactform-name">Nama <small>*</small></label>
                                                    <input type="text" id="nama" name="nama" value="" class="form-control required">
                                                </div>

                                                <div class="col-12 form-group mb-4">
                                                    <label class="color" for="template-contactform-email">Email<small>*</small></label>
                                                    <input type="email" id="email" name="email" value="" class="required email form-control">
                                                </div>

                                                <div class="col-12 form-group mb-4">
                                                    <label class="color" for="template-contactform-email">Subjek<small>*</small></label>
                                                    <input type="email" id="subjek" name="subjek" value="" class=" form-control required">
                                                </div>

                                                <div class="col-12 form-group mb-4">
                                                    <label class="color" for="template-contactform-message">Pesan <small>*</small></label>
                                                    <textarea class="required form-control" id="pesan" name="pesan" rows="4" cols="30"></textarea>
                                                </div>

                                                <div class="col-12 form-group mb-0">
                                                    <button class="button button-large button-rounded py-3 w-100 " id="button-kirim">Kirim</button>
                                                </div>
                                            </div>

                                            <input type="hidden" name="prefix" value="template-contactform-">

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

    </div>
    </section><!-- #content end -->

    <!-- Footer
		============================================= -->
    <?= $this->include('partials/user_footer') ?>
    <!-- #footer end -->
    </div>
    <!-- #wrapper end -->

    <!-- Go To Top
	============================================= -->
    <div id="gotoTop" class="uil uil-angle-up"></div>

    <!-- JavaScripts
	============================================= -->
    <?= $this->include('partials/js') ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            $('#button-kirim').on('click', function(e) {
                e.preventDefault();

                // Kirim data formulir via AJAX
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('Kontak/kirim_email') ?>',
                    data: {
                        'nama': $('#nama').val(),
                        'email': $('#email').val(),
                        'subjek': $('#subjek').val(),
                        'pesan': $('#pesan').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.code == '200') {
                            // Proses sukses menggunakan SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message + ', Terima kasih atas pesan Anda. Kami akan segera merespons.',
                                showConfirmButton: true,
                            });

                            // Bersihkan semua input
                            $('#nama').val('');
                            $('#email').val('');
                            $('#subjek').val('');
                            $('#pesan').val('');

                        } else {
                            // Proses gagal menggunakan SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message,
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function(error) {
                        // Tampilkan pesan error jika terjadi kesalahan AJAX
                        Swal.fire({
                            title: 'Error!',
                            text: error.responseJSON?.message || error.message,
                            icon: 'error'
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>