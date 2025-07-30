<div id="page-menu" class="sticky-page-menu">
    <div id="page-menu-wrap">
        <div class="container">
            <div class="page-menu-row">

                <div class="page-menu-title"><?= $title->nama ?> <span>Gallery</span></div>

                <nav class="page-menu-nav">
                    <ul class="page-menu-container">
                        <li class="page-menu-item">
                            <a href="<?= base_url('Pustaka/gambar/') . $title->id  ?>">
                                <div>Gambar</div>
                            </a>
                        </li>
                        <li class="page-menu-item ">
                            <a href="<?= base_url('Pustaka/video/') . $title->id  ?>">
                                <div>Video</div>
                            </a>
                        </li>
                        <li class="page-menu-item">
                            <a href="<?= base_url('Pustaka/youtube/') . $title->id  ?>">
                                <div>Youtube</div>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div id="page-menu-trigger"><i class="bi-list"></i></div>

            </div>
        </div>
    </div>
</div>