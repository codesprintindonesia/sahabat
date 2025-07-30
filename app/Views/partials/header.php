<!-- Header
		============================================= -->
<header id="header">
    <div id="header-wrap">
        <div class="container">
            <div class="header-row">
                <!-- Logo
						============================================= -->
                <div id="logo" class="me-lg-5">
                    <a href="<?= base_url()?>">
                        <img class="logo-default" src="<?= base_url() ?>public/images/logo.png" alt="Logo">
                        <img class="logo-dark" src="<?= base_url() ?>public/images/logo.png" alt="Logo">
                    </a>
                </div><!-- #logo end -->

                <div class="primary-menu-trigger">
                    <button class="cnvs-hamburger" type="button" title="Open Mobile Menu">
                        <span class="cnvs-hamburger-box"><span class="cnvs-hamburger-inner"></span></span>
                    </button>
                </div>

                <!-- Primary Navigation
                ============================================= -->
                <nav class="primary-menu me-lg-auto">

                    <ul class="menu-container">
                        <li class="menu-item">
                            <a class="menu-link" href="<?= base_url() ?>Dashboard ">
                                <div>Dashboard</div>
                            </a>
                        </li>
                        <li class="menu-item current">
                            <a class="menu-link" href="#">
                                <div>Master <i class="bi-caret-down-fill text-smaller d-none d-xl-inline-block me-0"></i><i class="sub-menu-indicator fa-solid fa-caret-down"></i></div>
                            </a>
                            <ul class="sub-menu-container">
                                <li class="menu-item">
                                    <a class="menu-link" href="<?= base_url() ?>Master/Landing">
                                        <div></i>Landing</div>
                                    </a>
                                </li>
                                <li class="menu-item-divider"></li>
                                <li class="menu-item">
                                    <a class="menu-link" href="<?= base_url() ?>Master/Carousel">
                                        <div></i>Carousel</div>
                                    </a>
                                </li>
                                <li class="menu-item-divider"></li>
                                <li class="menu-item">
                                    <a class="menu-link" href="<?= base_url() ?>Master/Tentang">
                                        <div></i>Tentang Kami</div>
                                    </a>
                                </li>
                                <li class="menu-item-divider"></li>
                                <li class="menu-item">
                                    <a class="menu-link" href="<?= base_url() ?>Master/Kategori">
                                        <div></i>Kategori</div>
                                    </a>
                                </li>
                                <li class="menu-item-divider"></li>
                                <li class="menu-item">
                                    <a class="menu-link" href="<?= base_url() ?>Master/Item">
                                        <div></i>Item</div>
                                    </a>
                                </li>
                                <li class="menu-item-divider"></li>
                                <li class="menu-item">
                                    <a class="menu-link" href="<?= base_url() ?>Master/Gambar">
                                        <div></i>Gambar</div>
                                    </a>
                                </li>
                                <li class="menu-item-divider"></li>
                                <li class="menu-item">
                                    <a class="menu-link" href="<?= base_url() ?>Master/VideoYoutube">
                                        <div></i>Video Youtube</div>
                                    </a>
                                </li>
                                <li class="menu-item-divider"></li>
                                <li class="menu-item">
                                    <a class="menu-link" href="<?= base_url() ?>Master/VideoLokal">
                                        <div></i>Video Lokal</div>
                                    </a>
                                </li>
                                <?php if (session()->get('role') == 1) { ?>
                                    <li class="menu-item-divider"></li>
                                    <li class="menu-item">
                                        <a class="menu-link" href="<?= base_url() ?>Master/Pengguna">
                                            <div></i>Pengguna</div>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="menu-item ms-auto sub-menu">
                            <a class="menu-link" href="#">
                                <div><?= session()->get('username') ?> <i class="bi-caret-down-fill text-smaller d-none d-xl-inline-block me-0"></i><i class="sub-menu-indicator fa-solid fa-caret-down"></i></div>
                            </a>
                            <ul class="sub-menu-container">
                                <li class="menu-item">
                                    <a class="menu-link" href="<?= base_url('Auth/ubah_password') ?>">
                                        <div>Ubah Password</div>
                                    </a>
                                </li>
                                <li class="menu-item-divider"></li>
                                <li class="menu-item">
                                    <a class="menu-link" href="<?= base_url('Auth/logout') ?>">
                                        <div>Keluar</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </nav><!-- #primary-menu end -->

                <form class="top-search-form" action="search.html" method="get">
                    <input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off">
                </form>

            </div>
        </div>
    </div>
    <div class="header-wrap-clone"></div>
</header><!-- #header end -->