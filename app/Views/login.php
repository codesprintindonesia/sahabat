<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="x-ua-compatible" content="IE=edge">
	<meta name="author" content="Disperindag Provinsi Sultra | Sahabat Agro">
	<meta name="description" content="Selamat datang di halaman login Sahabat Agro. Masuk untuk mengakses akun Anda.">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Contoh meta tag untuk sosial media -->
	<meta property="og:title" content="<?= $title ?>">
	<meta name="description" content="Selamat datang di halaman login Sahabat Agro. Masuk untuk mengakses akun Anda.">
	<meta property="og:image" content="<?= base_url() ?>public/images/logo-daun-kecil.png">
	<meta property="og:url" content="<?= base_url() ?>">

	<!-- Favicon -->
	<link rel="icon" href="<?= base_url() ?>public/images/logo-daun-kecil.ico" type="image/x-icon">
	<?= $this->include('partials/css') ?>

	<!-- Document Title
	============================================= -->
	<title><?= $title ?></title>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper">

		<!-- Content
		============================================= -->
		<section id="content">
			<div class="content-wrap py-0">

				<div class="section p-0 m-0 h-100 position-absolute" style="background: url('<?= base_url() ?>public/images/background.jpg') center center no-repeat; background-size: cover;"></div>

				<div class="section bg-transparent min-vh-100 p-0 m-0">
					<div class="vertical-middle">
						<div class="container-fluid py-5 mx-auto">
							<div class="card mx-auto rounded-0 border-0" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
								<div class="card-body" style="padding: 40px 40px 40px 40px;">
									<div class="text-center">
										<a href="<?= base_url() ?>"><img style="width: 300px;" src="<?= base_url('public/images/logo.png') ?>" alt="Logo"></a>
									</div>
									<hr>
									<form id="login-form" name="login-form" class="mb-0">
										<h4 class="mb-3 text-center">Masuk untuk mengakses akun Anda</h4><br>
										<div class="row">
											<div class="col-12 form-group">
												<input placeholder="Username" type="text" id="username" name="username" value="" class="form-control not-dark">
											</div>

											<div class="col-12 form-group">
												<input placeholder="Password" type="password" id="password" name="password" value="" class="form-control not-dark">
											</div>
											<div class="col-12 form-group ">
												<br>
												<div class="d-flex justify-content-between ">
													<button class="button button-3d button-black w-100 m-0" id="button-login" name="button-login">Masuk</button>
												</div>
											</div>
										</div>
									</form>

								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<?= $this->include('partials/user_footer') ?>
		<!-- #footer end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="uil uil-angle-up"></div>

	<!-- JavaScripts
	============================================= -->
	<?= $this->include('partials/js') ?>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script>
		$(document).ready(function() {
			$('#button-login').click(function(e) {
				e.preventDefault();
				var username = $('#username').val();
				var password = $('#password').val();
				$.ajax({
					type: 'POST',
					url: '<?= base_url('Auth/login') ?>',
					data: {
						username: username,
						password: password
					},
					success: function(response) {
						if (response.code == 200) {
							window.location.href = `<?= base_url('Master/Carousel') ?>`;
						} else {
							// Tampilkan pesan kesalahan menggunakan SweetAlert
							Swal.fire({
								icon: 'warning',
								title: 'Oops...',
								text: response.message
							});
						}
					},
					error: function(error) {
						Swal.fire({
							icon: 'error',
							title: error.responseJSON?.code || 'Oops...',
							text: error.responseJSON?.message || error.message,
						});
					}
				});
			});
		});
	</script>
	</script>

</body>

</html>