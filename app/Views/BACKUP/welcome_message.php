<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
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
    <title>Sahabat Agro</title>

    <style>
        .page-section {
            padding: 60px 0;
        }

        .square-image {
            height: 400px !important;
            object-fit: cover;
            object-position: center center;
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

        <!-- Slider
		============================================= -->
        <section id="slider" class="slider-element min-vh-60 min-vh-md-100 with-header swiper_wrapper include-header">
            <div class="slider-inner">
                <div class="swiper swiper-parent">
                    <div class="swiper-wrapper">
                        <?php foreach ($list_carousel as $carousel) {
                            $filename = base_url() . "public/uploads/carousel/original/" . $carousel->filename;
                        ?>
                            <div class="swiper-slide dark">
                                <div class="container">
                                    <div class="slider-caption slider-caption-center">
                                        <h2 data-animate="fadeInUp" style="text-transform: none;">
                                            <?= $carousel->judul ?>
                                        </h2>
                                        <p class="d-none d-sm-block" data-animate="fadeInUp" data-delay="200">
                                            <?= $carousel->deskripsi ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="swiper-slide-bg" style="
                                    background-image: url('<?= $filename ?>');
                                    filter: brightness(0.7);
                                ">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="slider-arrow-left">
                        <i class="uil uil-angle-left-b"></i>
                    </div>
                    <div class="slider-arrow-right">
                        <i class="uil uil-angle-right-b"></i>
                    </div>
                    <div class="slide-number">
                        <div class="slide-number-current"></div>
                        <span>/</span>
                        <div class="slide-number-total"></div>
                    </div>
                    <a href="#" data-scrollto="#section-about" class="one-page-arrow dark">
                        <i class="bi-chevron-down infinite animated fadeInDown"></i>
                    </a>
                </div>

                <div class="video-wrap">
                    <div class="video-overlay" style="background-color: rgba(0, 0, 0, 0.55)"></div>
                </div>

                <a href="#" data-scrollto="#section-about" data-easing="easeInOutExpo" data-speed="1250" data-offset="65" class="one-page-arrow dark"><i class="bi-chevron-down infinite animated fadeInDown"></i></a>
            </div>
        </section>

        <!-- #slider end -->

        <!-- Content
		============================================= -->
        <section id="content">
            <div class="content-wrap">
                <section id="section-about" class="page-section">
                    <div class="container">
                        <div class="heading-block text-center">
                            <h2>
                                Tentang Kami
                                <!-- <span>Kami</span> -->
                            </h2>
                            <span>Sahabat Agro adalah mitra terpercaya dalam transformasi industri pertanian. Kami memimpin dengan inovasi untuk memberdayakan petani, menyediakan solusi terdepan dalam pengolahan, pengemasan, dan pelatihan ekspor.</span>
                        </div>

                        <div class="row justify-content-center col-mb-50">
                            <?php foreach ($list_tentang as $tentang) { ?>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="feature-box media-box">
                                        <div class="fbox-media">
                                            <img src="<?= base_url() ?>public/uploads/tentang/original/<?= $tentang->filename ?>" alt="Why choose Us?" />
                                        </div>
                                        <div class="fbox-content px-0">
                                            <h3>
                                                <?= $tentang->judul ?>
                                            </h3>
                                            <p style="text-align: justify;">
                                                <?= $tentang->deskripsi ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="section parallax scroll-detect py-6 dark">
                        <img src="https://images.unsplash.com/photo-1657132683776-9e18bb1d312b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2080&q=80" class="parallax-bg" style="filter: brightness(0.7);" />
                        <div class="heading-block text-center border-bottom-0 mb-0">
                            <h2 class="container">
                                "Dalam perdagangan, komoditas membangun jembatan antara budaya dan kemakmuran, mengilhami pertumbuhan ekonomi yang berkelanjutan."
                            </h2>
                        </div>
                    </div>

                </section>

                <section id="section-works" class="page-section">
                    <div class="heading-block text-center">
                        <h2>Pustaka</h2>
                        <span>Temukan pengetahuan bermakna melalui koleksi video dan gambar edukatif kami, membuka pintu menuju pertumbuhan dan inspirasi.</span>
                    </div>
                    <div class="container">
                        <div id="portfolio" class="portfolio row g-1 portfolio-reveal ">
                            <?php foreach ($list_gambar as $gambar) { ?>
                                <article class="portfolio-item col-6 col-md-4 col-lg-3">
                                    <div class="grid-inner">
                                        <div class="portfolio-image">
                                            <a href="<?= base_url('Blog/gambar/' . $gambar->id) ?>">
                                                <img class="square-image" src="<?= base_url('public/uploads/gambar/original/') . $gambar->filename ?>" alt="Open Imagination">
                                            </a>
                                        </div>
                                        <div class="portfolio-desc">
                                            <h3><a href="<?= base_url('Blog/gambar/' . $gambar->id) ?>"><?= $gambar->judul ?></a></h3>
                                        </div>
                                    </div>
                                </article>
                            <?php } ?>
                        </div>
                        <a href="<?= base_url('Pustaka/gambar/1') ?>" class="button button-full button-dark text-center text-end mb-6">
                            <div class="container">
                                Tampilkan <strong>Lebih Banyak</strong> <i class="fa-solid fa-caret-right" style="top:4px;"></i>
                            </div>
                        </a>
                    </div>
                    <!-- ====================================================================== -->

                </section>

                <!-- Video Section
					============================================= -->
                <div class="container">
                    <div class="d-flex justify-content-between mb-4">
                        <h3 class="font-body fw-medium m-0">Latest Videos on Youtube</h3>
                        <a href="<?= base_url('Pustaka/youtube/1') ?>" class="button button-border button-border-thin button-secondary">More Content <i class="bi-arrow-right"></i></a>
                    </div>

                    <div class="row posts-md col-mb-30">
                        <?php foreach ($list_videoyoutube as $video) { ?>
                            <div class="col-md-4">
                                <div class="video-facade position-relative" data-video-html='<iframe  src="<?= $video->preview ?>" allowfullscreen></iframe>'>
                                    <div class="video-facade-preview">
                                        <img src="http://img.youtube.com/vi/<?= $video->youtube_id ?>/0.jpg" alt="Video Facade Video Preview" class="w-100">
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content dark">
                                                <a href="#" class="overlay-trigger-icon size-lg op-ts op-07 bg-light text-dark" data-hover-animate="op-1" data-hover-animate-out="op-07"><i class="bi-play-fill fs-2 position-relative" style="left:1px"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="video-facade-content"></div>
                                </div>
                                <div class="portfolio-desc">
                                    <h3><a target="_blank" href="<?= $video->link ?>"><?= $video->judul ?> </a></h3>
                                    <span><?= time_ago($video->updated_at) ?></span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div> <!-- Video Section End -->

                <!-- <section id="section-contact" class="page-section">
                    <div class="heading-block text-center">
                        <h2>Kontak Kami</h2>
                        <span>Jangan ragu untuk terhubung. Kami tersedia untuk membantu Anda dengan pertanyaan, saran, atau kerjasama yang Anda perlukan.</span>
                    </div>

                    <div class="container">
                        <div class="row align-items-stretch col-mb-50 mb-0"> 
                            <div class="col-lg-12">
                                <div class="fancy-title title-border">
                                    <h3>Kirim Email</h3>
                                </div>

                                <div class="form-widget">
                                    <div class="form-result"></div>

                                    <form class="mb-0" id="template-contactform" name="template-contactform" action="include/form.php" method="post">
                                        <div class="form-process">
                                            <div class="css3-spinner">
                                                <div class="css3-spinner-scaler"></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="template-contactform-name">Name <small>*</small></label>
                                                <input type="text" id="template-contactform-name" name="template-contactform-name" value="" class="form-control required" />
                                            </div>

                                            <div class="col-md-4 form-group">
                                                <label for="template-contactform-email">Email <small>*</small></label>
                                                <input type="email" id="template-contactform-email" name="template-contactform-email" value="" class="required email form-control" />
                                            </div>

                                            <div class="col-md-4 form-group">
                                                <label for="template-contactform-phone">Phone</label>
                                                <input type="text" id="template-contactform-phone" name="template-contactform-phone" value="" class="form-control" />
                                            </div>

                                            <div class="w-100"></div>

                                            <div class="col-md-12 form-group">
                                                <label for="template-contactform-subject">Subject <small>*</small></label>
                                                <input type="text" id="template-contactform-subject" name="subject" value="" class="required form-control" />
                                            </div>

                                            <div class="w-100"></div>

                                            <div class="col-12 form-group">
                                                <label for="template-contactform-message">Message <small>*</small></label>
                                                <textarea class="required form-control" id="template-contactform-message" name="template-contactform-message" rows="6" cols="30"></textarea>
                                            </div>

                                            <div class="col-12 form-group d-none">
                                                <input type="text" id="template-contactform-botcheck" name="template-contactform-botcheck" value="" class="form-control" />
                                            </div>

                                            <div class="col-12 form-group">
                                                <button class="button button-3d m-0" type="submit" id="template-contactform-submit" name="template-contactform-submit" value="submit">
                                                    Send Message
                                                </button>
                                            </div>
                                        </div>

                                        <input type="hidden" name="prefix" value="template-contactform-" />
                                    </form>
                                </div>
                            </div> 
                        </div>
                </section> -->
            </div>
        </section>
        <!-- #content end -->

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