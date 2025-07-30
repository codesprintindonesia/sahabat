<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="author" content="SemiColonWeb">
    <meta name="description" content="Get Canvas to build powerful websites easily with the Highly Customizable &amp; Best Selling Bootstrap Template, today.">

    <?= $this->include('partials/css') ?>

    <!-- Plugins/Components CSS -->
    <?= $this->renderSection('css') ?>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url() ?>public/images/logo-daun-kecil.ico" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Document Title
	============================================= -->
    <title><?= $title ?></title>

    <style>
        #header-wrap #logo img {
            height: 50px;
        }

        table td {
            vertical-align: middle;
        }
    </style>
</head>

<body class="stretched">

    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper">

        <!-- Header
		============================================= -->
        <?= $this->include('partials/header') ?>

        <!-- Page Title
		============================================= -->
        <?php //echo $this->include('partials/page_title') 
        ?>

        <!-- Content
		============================================= -->
        <section id="content">
            <div class="content-wrap" style="padding-top: 30px;">
                <div class="container">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </section><!-- #content end -->

        <!-- Footer
		============================================= -->
        <?= $this->include('partials/user_footer') ?>

    </div><!-- #wrapper end -->

    <!-- Go To Top
	============================================= -->
    <div id="gotoTop" class="uil uil-angle-up"></div>

    <!-- JavaScripts
	============================================= -->
    <?= $this->include('partials/js') ?>

    <!-- Plugin -->
    <?= $this->renderSection('js') ?>
</body>

</html>