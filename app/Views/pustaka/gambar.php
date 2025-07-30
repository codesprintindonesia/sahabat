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
    <meta property="og:title" content="<?= $title->nama . " - " . $title->kategori ?>">
    <meta property="og:description" content="Selamat datang di Sahabat Agro, layanan unggulan dari Dinas Perindustrian dan Perdagangan untuk membantu pertumbuhan sektor pertanian, meningkatkan produktivitas, dan mendukung kesejahteraan pelaku usaha di bidang agroindustri.">
    <meta property="og:image" content="<?= base_url('public/uploads/item/thumbnail/' . $title->filename) ?>">
    <meta property="og:url" content="<?= base_url('Pustaka/gambar') . $title->id ?>">

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url() ?>public/images/logo-daun-kecil.ico" type="image/x-icon">
    <!-- Stylesheets
    ============================================= -->
    <?= $this->include('partials/css') ?>

    <!-- Document Title
	============================================= -->
    <title><?= $title->nama ?> - Sahabat Agro</title>
</head>

<body class="stretched">
    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper">
        <!-- Header
		============================================= -->
        <?= $this->include('partials/user_header') ?>
        <!-- #header end -->

        <!-- Page Title
		============================================= -->
        <?= $this->include('partials/user_page_title') ?>
        <!-- .page-title end -->

        <!-- Page Sub Menu
		============================================= -->
        <?= $this->include('partials/page_sub_menu') ?>
        <!-- #page-menu end -->

        <!-- Content
		============================================= -->
        <section id="content">
            <div class="content-wrap">
                <div class="container">

                    <!-- Portfolio Items
        ============================================= -->
                    <div class="container">
                        <h3 class="fs-4 fw-medium">Gambar</h3><hr>
                    </div>
                    <div id="portfolio" class="portfolio row grid-container gutter-20 text-center">
                        <?php foreach ($list_gambar as $key => $value) { ?>
                            <!-- Portfolio Item: Start -->
                            <article class="portfolio-item col-lg-1-5 col-md-4 col-sm-6 col-12">
                                <!-- Grid Inner: Start -->
                                <div class="grid-inner">
                                    <!-- Image: Start -->
                                    <div class="portfolio-image" style="border-radius: 20px">
                                        <a href="portfolio-single.html"">
                                            <img src=" <?= base_url('public/uploads/gambar/thumbnail/' . $value->filename) ?>" alt="Open Imagination">
                                        </a>
                                        <!-- Overlay: Start -->
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content dark flex-column" data-hover-animate="fadeIn">
                                                <!-- Decription: Start -->
                                                <div class="portfolio-desc pt-0" data-hover-animate="fadeInDownSmall" data-hover-animate-out="fadeOutUpSmall" data-hover-speed="350">
                                                    <h3><a href="<?= base_url('Blog/gambar/') . $value->id ?>"><?= $value->judul ?></a></h3>
                                                </div>
                                                <!-- Description: End -->
                                                <div class="d-flex">
                                                    <a href="<?= base_url('public/uploads/gambar/original/' . $value->filename) ?>" class="overlay-trigger-icon bg-light text-dark" data-hover-animate="fadeInUpSmall" data-hover-animate-out="fadeOutDownSmall" data-hover-speed="350" data-lightbox="image" title="<?= $value->judul ?>"><i class="uil uil-plus"></i></a>
                                                </div>
                                            </div>
                                            <div class="bg-overlay-bg dark" data-hover-animate="fadeIn"></div>
                                        </div>
                                        <!-- Overlay: End -->
                                    </div>
                                    <!-- Image: End -->
                                </div>
                                <!-- Grid Inner: End -->
                            </article>
                            <!-- Portfolio Item: End -->
                        <?php } ?>

                        <?php if (count($list_gambar) == 0) { ?>
                            <div> 
                                <img src="<?= base_url() ?>public/images/404.png" alt="No Data Found" style="margin: 40px 0px">
                                <h3 class="text-center" style="color: #3d8338;">
                                     Data tidak ditemukan
                                </h3>
                            </div>
                        <?php } ?>

                    </div><!-- #portfolio end -->
                    <br>
                    <br>
                    <div id="pagination" class="text-center">

                    </div>
                    <!-- Tampilkan Pagination -->
                    <?= $pager ?>

                </div>
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