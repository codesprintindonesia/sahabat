<div id="preloader" style="display: none;">
    <div id="loading-icon"></div>
</div>

<style>
    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: opacity 0.3s ease;
    }

    #loading-icon {
        width: 50px;
        /* Sesuaikan dengan ukuran ikon Anda */
        height: 50px;
        /* Sesuaikan dengan ukuran ikon Anda */
        background: url('<?= base_url('public/images/preloader.gif') ?>') center center no-repeat;
    }
</style>

<footer id="footer" class="dark">
    <div id="copyrights">
        <div class="container-fluid px-5"> 
            <div class="row col-mb-30"> 
                <div class="col-md-12 text-center text-md-start">
                    Copyrights &copy; 2023 All Rights Reserved by Sahabat Agro<br> 
                </div> 
            </div> 
        </div>
    </div><!-- #copyrights end --> 
</footer><!-- #footer end -->