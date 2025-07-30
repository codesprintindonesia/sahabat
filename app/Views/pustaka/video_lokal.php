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
                        <h3 class="fs-4 fw-medium">Video</h3><hr>
                    </div>
                    <div id="portfolio" class="portfolio row grid-container gutter-20 text-center">
                        <?php foreach ($list_videolokal as $key => $value) { ?>
                            <!-- Portfolio Item: Start -->
                            <article class="portfolio-item col-lg-3 col-md-4 col-sm-6 col-12">
                                <!-- Grid Inner: Start -->
                                <div class="grid-inner">
                                    <video class="d-block w-100" poster="" preload="auto" controls style="border-radius: 20px;">
                                        <source src='<?= base_url() ?>public/uploads/videos/<?= $value->filename ?>?>' type='video/mp4'>
                                    </video>
                                    <div class="portfolio-desc">
                                        <h3><a href="<?= base_url('Blog/video_lokal/') . $value->id ?>"><?= $value->judul ?> </a></h3>
                                        <span><?= time_ago($value->updated_at) ?></span>
                                    </div>
                                </div>
                                <!-- Grid Inner: End -->
                            </article>
                            <!-- Portfolio Item: End -->
                        <?php } ?> 

                        <?php if (count($list_videolokal) == 0) { ?>
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
    <script src="<?= base_url() ?>public/js/jquery.js"></script>
    <script src="<?= base_url() ?>public/js/plugins.min.js"></script>
    <script src="<?= base_url() ?>public/js/functions.bundle.js"></script>
</body>

</html>