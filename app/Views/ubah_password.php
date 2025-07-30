<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="section bg-transparent min-vh-100 p-0 m-0">
	<div class="vertical-middle">
		<div class="container-fluid py-5 mx-auto">
			<div class="card mx-auto rounded-0 border-0" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
				<div class="card-body" style="padding: 40px;">
					<form id="login-form" name="login-form" class="mb-0">
						<h3>Ubah Password</h3>

						<div class="row">
							<div class="col-12 form-group">
								<input placeholder="Password Lama" type="password" class="form-control" id="password_lama" name="password_lama" required>
							</div>
							<div class="col-12 form-group">
								<input placeholder="Password Baru" type="password" class="form-control" id="password_baru" name="password_baru" required>
							</div>
							<div class="col-12 form-group">
								<input placeholder="Konfimasi Password Baru" type="password" class="form-control" id="konfirmasi_password_baru" name="konfirmasi_password_baru" required>
							</div>
							<div class="col-12 form-group ">
								<br>
								<div class="d-flex justify-content-between ">
									<button class="button button-3d button-black w-100 m-0" id="button-simpan" name="button-simpan">Simpan</button>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
	/* Tambahkan CSS kustom jika diperlukan */
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<?= $this->endSection() ?>

<!-- JavaScripts
	============================================= -->
<?= $this->section('js') ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
	$(document).ready(function() {
		// Event saat formulir ubah password disubmit
		$('#login-form').submit(function(event) {
			event.preventDefault();

			// Mengambil data dari form
			var passwordLama = $('#password_lama').val();
			var passwordBaru = $('#password_baru').val();
			var konfirmasiPasswordBaru = $('#konfirmasi_password_baru').val();

			// Validasi data
			if (passwordBaru !== konfirmasiPasswordBaru) {
				// Tampilkan pesan kesalahan jika password baru dan konfirmasi tidak cocok
				Swal.fire({
					icon: 'error',
					title: 'Error!',
					text: 'Password baru dan konfirmasi password tidak cocok.',
				});
				return;
			}

			// Kirim data ke server menggunakan AJAX
			$.ajax({
				url: '<?= base_url('Auth/ubah_password_proses') ?>', // Sesuaikan dengan endpoint API untuk mengubah password
				type: 'POST',
				data: {
					password_lama: passwordLama,
					password_baru: passwordBaru,
					konfirmasi_password_baru: konfirmasiPasswordBaru
				},
				dataType: 'json',
				success: function(response) {
					if (response.code == 200) {
						// Password berhasil diubah, tampilkan pesan sukses menggunakan SweetAlert2
						Swal.fire({
							icon: 'success',
							title: 'Sukses!',
							text: response.message,
						}) 
					} else {
						// Password gagal diubah, tampilkan pesan error menggunakan SweetAlert2
						Swal.fire({
							icon: 'error',
							title: 'Error!',
							text: response.message,
						});
					}
				},
				error: function(error) {
					// Tampilkan pesan error jika terjadi kesalahan AJAX menggunakan SweetAlert2
					Swal.fire({
						title: 'Error!',
						text: error.responseJSON?.message || error.message,
						icon: 'error'
					});
				}
			});
		});
	});
</script>
<?= $this->endSection() ?>