<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="author" content="Disperindag Provinsi Sultra | Sahabat Agro">
    <meta name="description" content="Selamat datang di Sahabat Agro, layanan unggulan dari Dinas Perindustrian dan Perdagangan untuk membantu pertumbuhan sektor pertanian, meningkatkan produktivitas, dan mendukung kesejahteraan pelaku usaha di bidang agroindustri.">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Tambahkan meta tag lainnya sesuai kebutuhan -->

    <!-- Contoh meta tag untuk SEO -->
    <meta name="keywords" content="pertanian, agroindustri, perdagangan, industri, kesejahteraan, Dinas Perindustrian dan Perdagangan">

    <!-- Contoh meta tag untuk sosial media -->
    <meta property="og:title" content="<?= $title ?>">
    <meta property="og:description" content="Selamat datang di Sahabat Agro, layanan unggulan dari Dinas Perindustrian dan Perdagangan untuk membantu pertumbuhan sektor pertanian, meningkatkan produktivitas, dan mendukung kesejahteraan pelaku usaha di bidang agroindustri.">
    <meta property="og:image" content="<?= base_url() ?>public/images/logo-daun-kecil.png">
    <meta property="og:url" content="<?= base_url() ?>">

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url() ?>public/images/logo-daun-kecil.ico" type="image/x-icon">

    <!-- Stylesheets
    ============================================= -->
    <?= $this->include('partials/css') ?>

    <!-- One Page Module Specific Stylesheet -->
    <link rel="stylesheet" href="<?= base_url() ?>public/one-page/onepage.css" />

    <!-- Plugins/Components CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>public/css/swiper.css" />

    <!-- Document Title
	============================================= -->
    <title><?= $title ?></title>

    <style>
        .block-hero-6 .font-secondary {
            font-family: 'Grand Hotel', cursive;
        }

        .block-hero-6 {
            --color: 34, 46, 43;
        }

        .block-hero-6 .hero-img {
            border: 16px solid #FFF;
        }

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

        <!-- Hero Section
		============================================= -->
        <section id="slider" class="slider-element py-6 block-hero-6" style="background: url('<?= base_url() ?>public/images/background.jpg') center center no-repeat; background-size: cover;">
            <!-- Overlay untuk efek gelap dan buram -->
            <div class="overlay"></div>
            <?php foreach ($list_landing as $landing) { ?>
                <div class="container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-5">
                            <img data-animate="fadeIn" data-delay="400" src="<?= base_url() ?>public/uploads/landing/original/<?= $landing->filename ?>" alt="image" style="border-radius: 10px" class=" border-bottom shadow border-width border-width-2">
                        </div>
                        <div class="col-md-6 mt-5 mt-md-0">
                            <img data-animate="fadeInUp" data-delay="100" src="<?= base_url() ?>public/images/sultra.png" alt="image" class="mb-4" style="height: 100px;">
                            <img data-animate="fadeInUp" data-delay="200" src="<?= base_url() ?>public/images/logo-daun-kecil.png" alt="image" class="mb-4" style="height: 100px;">
                            <h2 data-animate="fadeInUp" data-delay="300" class="display-3 fw-bold" style="color: #1abc9c;"><?= $landing->judul ?></h2>
                            <p data-animate="fadeIn" data-delay="400" class="lead text-white">
                                <?= $landing->deskripsi ?>
                            </p>
                            <a data-animate="fadeIn" data-delay="500" href="<?= base_url('Home/index') ?>" class="button button-circle button-xlarge button-reveal text-end ls-0 m-0" style="padding-left: 60px;padding-right: 60px;"><span>Beranda</span><i class="bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>

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

</body>

</html>