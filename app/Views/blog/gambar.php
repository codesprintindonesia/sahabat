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
    <meta property="og:description" content="<?= $gambar->judul . " - " . $gambar->nama_item ?>">
    <meta property="og:image" content="<?= base_url('public/uploads/gambar/thumbnail/' . $gambar->filename) ?>">
    <meta property="og:url" content="<?= base_url('Blog/gambar/') . $gambar->id ?>">

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url() ?>public/images/logo-daun-kecil.ico" type="image/x-icon">
    <!-- Stylesheets
    ============================================= -->
    <?= $this->include('partials/css') ?>

    <!-- Document Title
	============================================= -->
    <title><?= $title ?></title>
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
        <section id="content">
            <div class="content-wrap">
                <div class="container">
                    <div class="single-post mb-0">

                        <!-- Single Post
                        ============================================= -->
                        <div class="entry">

                            <!-- Entry Title
                            ============================================= -->
                            <div class="entry-title">
                                <h2><?= $gambar->judul ?></h2>
                            </div><!-- .entry-title end -->

                            <!-- Entry Meta
                            ============================================= -->
                            <div class="entry-meta">
                                <ul>
                                    <li><i class="uil uil-schedule"></i> <?= time_ago($gambar->updated_at) ?></li>
                                    <li><i class="uil uil-folder-open"></i><a href="<?= base_url('Pustaka/gambar/' . $gambar->item_id) ?>"><?= $gambar->nama_item ?></a></li>
                                    <li><i class="uil uil-eye"></i>dibaca : <?= $gambar->views_count ?></li>
                                </ul>
                            </div><!-- .entry-meta end -->

                            <!-- Entry Image
                            ============================================= -->
                            <div class="entry-image mb-5">
                                <a href="#"><img style="max-height: 500px; object-fit: cover" src="<?= base_url('public/uploads/gambar/original/') . $gambar->filename ?>" alt="Blog Single"></a>
                            </div><!-- .entry-image end -->

                            <!-- Entry Content
                            ============================================= -->
                            <div class="entry-content mt-0">
                                <?= $gambar->deskripsi ?>
                                <!-- Post Single - Content End --> 
                                <hr> 
                            </div>
                        </div><!-- .entry end -->


                    </div>
                    <div id="disqus_thread"></div>
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

    <script>
        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */

        var disqus_config = function() {
            this.page.url = '<?= base_url(uri_string()) ?>'; // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = 'blogGambar-' + <?= $gambar->id ?>; // Replace PAGE_IDENTIFIER with your page's unique identifier variable 
        };

        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document,
                s = d.createElement('script');
            s.src = 'https://sahabatagro.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
</body>

</html>