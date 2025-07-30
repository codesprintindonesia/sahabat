<!-- <header id="header" class="header " data-sticky-shrink="false" data-sticky-class="not-dark" data-sticky-offset="full" data-sticky-offset-negative="auto"> -->
<header id="header" class="full-header transparent-header transparent-header-responsive" data-sticky-class="not-dark" data-bs-theme="dark">
    <div id="header-wrap">
        <div class="container">
            <div class="header-row">
                <!-- Logo
						============================================= -->
                <div id="logo">
                    <a href="<?= base_url() ?>">
                        <img class="logo-default" src="<?= base_url() ?>public/images/logo.png" style="max-height: 50px; padding: 5px 0px;" alt="Canvas Logo" />
                    </a>
                </div>
                <!-- #logo end -->

                <div class="primary-menu-trigger">
                    <button class="cnvs-hamburger" type="button" title="Open Mobile Menu">
                        <span class="cnvs-hamburger-box"><span class="cnvs-hamburger-inner"></span></span>
                    </button>
                </div>

                <!-- Primary Navigation
						============================================= -->
                <nav class="primary-menu">
                    <ul class="one-page-menu menu-container" data-easing="easeInOutExpo" data-speed="1250" data-offset="65">
                        <li class="menu-item">
                            <a href="<?= base_url('Home/index') ?>" class="menu-link">
                                <div>Beranda</div>
                            </a>
                        </li>
                        <?php foreach ($list_kategori as $kategori) { ?>
                            <li class="menu-item">
                                <a class="menu-link" href="#">
                                    <div><?= $kategori->nama ?> <i class="bi-caret-down-fill text-smaller d-none d-xl-inline-block me-0"></i><i class="sub-menu-indicator fa-solid fa-caret-down"></i></div>
                                </a>
                                <ul class="sub-menu-container not-dark">
                                    <?php foreach ($list_item as $item) { ?>
                                        <?php if ($kategori->id == $item->kategori_id) { ?>
                                            <li class="menu-item">
                                                <a class="menu-link" href="<?= base_url('Pustaka/gambar/') . $item->id ?>">
                                                    <div><?= $item->nama ?></div>
                                                </a>
                                            </li>
                                    <?php }
                                    } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <li class="menu-item">
                            <a href="<?= base_url('Kontak') ?>" class="menu-link">
                                <div>Kontak</div>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- #primary-menu end -->
            </div>
        </div>
    </div>
    <div class="header-wrap-clone"></div>
</header>