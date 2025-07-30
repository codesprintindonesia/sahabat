<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="">
    <div class="row"> 
        <h3><?= $title ?></h3><hr>
    </div>
    <div class="row"> 
        <div class="col-auto ms-auto">
            <button class="button button-border-thin button-border button-blue button-small" data-bs-toggle="modal" data-bs-target="#addModal">Tambah</button>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table id="landingDatatable" class="table hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th> 
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Landing</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th> 
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Landing</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody></tbody> <!-- Data tabel akan diisi melalui AJAX -->
        </table>
    </div>

    <!-- Modal Form Edit Landing -->
    <div class="modal fade text-start" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">Edit Landing</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditLanding" enctype="multipart/form-data">
                        <input type="hidden" id="editIdLanding" name="editIdLanding"> 
                        <div class="form-group">
                            <label for="editInputJudul">Judul:</label>
                            <input type="text" class="form-control" id="editInputJudul" placeholder="Masukkan Judul" required>
                        </div>
                        <div class="form-group">
                            <label for="editInputDeskripsi">Deskripsi:</label>
                            <textarea class="form-control" rows="10" id="editInputDeskripsi" placeholder="Masukkan Deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editInputLanding">Landing Baru:</label>
                            <input type="file" class="form-control" id="editInputLanding" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="editCurrentImage">Landing Saat Ini:</label>
                            <img src="" id="editCurrentImage" class="img-fluid form-control" style="width: 200px;" alt="Landing Saat Ini">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="updateLanding">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah Landing -->
    <div class="modal fade text-start" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Tambah Landing</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahLanding" enctype="multipart/form-data"> 
                        <div class="form-group">
                            <label for="inputJudul">Judul:</label>
                            <input type="text" class="form-control" id="inputJudul" placeholder="Masukkan Judul" required>
                        </div>
                        <div class="form-group">
                            <label for="inputDeskripsi">Deskripsi:</label>
                            <textarea class="form-control" rows="10" id="inputDeskripsi" placeholder="Masukkan Deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputLanding">Landing:</label>
                            <input type="file" class="form-control" id="inputLanding" accept="image/*" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="tambahLanding">Simpan</button>
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

<?= $this->section('js') ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() { 
        
        // Fungsi untuk mengambil dan menampilkan data landing
        function loadLandingData() {
            $.ajax({
                url: '<?= base_url('master/landing/find_all') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Menghapus DataTable yang ada
                    jQuery('#landingDatatable').DataTable().destroy();
                    // Mengosongkan tabel sebelum mengisi data baru
                    $('#landingDatatable tbody').empty();

                    // Mengisi tabel dengan data landing
                    $.each(response.data, function(index, landing) {
                        $('#landingDatatable tbody').append(`
                            <tr>
                                <td>${index + 1}</td> 
                                <td>${landing.judul}</td>
                                <td>${landing.deskripsi}</td>
                                <td class="text-center"><img src="<?= base_url('/public/uploads/landing/thumbnail/') ?>${landing.filename}" class="img-fluid" width="100" height="100" alt="Landing"></td>
                                <td class="text-center">
                                    <button class="button button-border-thin button-border button-amber button-small button-edit" data-id="${landing.id}">Edit</button>
                                    <button class="button button-border-thin button-border button-red button-small button-delete" data-id="${landing.id}">Delete</button>
                                </td>
                            </tr>
                        `);
                    });

                    jQuery('#landingDatatable').DataTable();
                },
                error: function(error) {
                    console.error('Terjadi kesalahan saat mengambil data landing:', error);
                }
            });
        }

        // Memanggil fungsi loadLandingData saat halaman pertama kali dimuat
        loadLandingData();

        // Event saat tombol "Simpan" pada modal ditekan
        $(document).on('click', '#tambahLanding', function() { 
            let judul = $('#inputJudul').val();
            let deskripsi = $('#inputDeskripsi').val();
            let landingFile = $('#inputLanding')[0].files[0];

            // Buat objek FormData untuk mengirim data yang lebih kompleks termasuk file
            let formData = new FormData(); 
            formData.append('judul', judul);
            formData.append('deskripsi', deskripsi);
            formData.append('landing', landingFile);

            // Kirim data ke server untuk tambah data menggunakan AJAX
            $.ajax({
                url: '<?= base_url('master/landing/create') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false, // Diperlukan untuk mengirim data FormData
                processData: false, // Diperlukan untuk mengirim data FormData
                success: function(response) {
                    if (response.code == 200) {
                        // Tutup modal jika tambah data berhasil
                        jQuery('#addModal').modal('hide');

                        // Bersihkan nilai input dalam modal
                        $('#inputItemId').val('');
                        $('#inputJudul').val('');
                        $('#inputDeskripsi').val('');
                        $('#inputLanding').val('');

                        // Tampilkan pesan sukses menggunakan SweetAlert2
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success'
                        });

                        // Refresh halaman atau muat ulang data landing jika diperlukan
                        loadLandingData();
                    } else {
                        // Tampilkan pesan error jika tambah data gagal
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(error) {
                    // Tampilkan pesan error jika terjadi kesalahan AJAX
                    Swal.fire({
                        title: 'Error!',
                        text: error.responseJSON?.message || error.message,
                        icon: 'error'
                    });
                }
            });
        }); 

        // Fungsi AJAX untuk delete 
        $(document).on('click', '.button-delete', function() {
            let categoryId = $(this).data('id');

            // Tampilkan konfirmasi menggunakan SweetAlert2
            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                // Jika pengguna mengkonfirmasi penghapusan
                if (result.isConfirmed) {
                    // Kirim permintaan DELETE ke endpoint
                    $.ajax({
                        url: '<?= base_url('master/landing/delete/') ?>' + categoryId,
                        type: 'DELETE',
                        success: function(response) {
                            // Tampilkan pesan sukses menggunakan SweetAlert2
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success'
                            });

                            // Memuat ulang data tabel setelah operasi selesai
                            loadLandingData();
                        },
                        error: function(error) {
                            // Tampilkan pesan kesalahan menggunakan SweetAlert2
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });

        // Event saat modal ditutup, bersihkan nilai input
        jQuery('#addModal').on('hidden.bs.modal', function() {
            $('#inputNamaLanding').val('');
            $('#inputLanding').val('');
        });

        // Event saat pengguna memilih landing baru di modal edit
        $(document).on('change', '#editInputLanding', function() {
            let inputLanding = this;
            if (inputLanding.files && inputLanding.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#editCurrentImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(inputLanding.files[0]);
            }
        });

        // Event click pada tombol "Edit" di tabel
        $(document).on("click", ".button-edit", function() {
            let landingId = $(this).data('id');

            // Ambil data dari server menggunakan AJAX dan isi formulir modal
            $.ajax({
                url: '<?= base_url('master/landing/find_by_id/') ?>' + landingId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Isi formulir modal dengan data dari server 
                        $('#editIdLanding').val(response.data.id);
                        $('#editInputJudul').val(response.data.judul);
                        $('#editInputDeskripsi').val(response.data.deskripsi); 

                        // Tampilkan landing saat ini
                        $('#editCurrentImage').attr('src', '<?= base_url('/public/uploads/landing/thumbnail/') ?>' + response.data.filename);

                        // Reset input landing baru
                        $('#editInputLanding').val('');

                        // Tampilkan modal
                        jQuery('#editModal').modal('show');
                    } else {
                        // Tampilkan pesan error jika gagal mengambil data
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengambil data landing.',
                            icon: 'error'
                        });
                    }
                },
                error: function(error) {
                    // Tampilkan pesan error jika terjadi kesalahan AJAX 
                    Swal.fire({
                        title: 'Error!',
                        text: error.responseJSON?.message || error.message,
                        icon: 'error'
                    });
                }
            });
        });


        // Event click pada tombol "Simpan Perubahan" di modal
        $(document).on("click", "#updateLanding", function() {
            // Ambil data dari formulir modal
            let landingId = $('#editIdLanding').val();
            let newJudul = $('#editInputJudul').val();
            let newDeskripsi = $('#editInputDeskripsi').val();
            let newLanding = $('#editInputLanding')[0].files[0];

            // Kirim data ke server untuk update menggunakan FormData
            let formData = new FormData();
            formData.append('id', landingId);
            formData.append('judul', newJudul);
            formData.append('deskripsi', newDeskripsi);
            formData.append('landing', newLanding);

            $.ajax({
                url: '<?= base_url('master/landing/update') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.code == 200) {
                        // Tutup modal jika update berhasil
                        jQuery('#editModal').modal('hide');

                        // Bersihkan nilai input dalam modal
                        $('#editIdLanding').val('');
                        $('#editInputJudul').val('');
                        $('#editInputDeskripsi').val('');
                        $('#editInputLanding').val('');
                        $('#editCurrentImage').attr('src', ''); // Kosongkan landing saat ini

                        // Memuat ulang data tabel setelah operasi selesai
                        loadLandingData();

                        // Tampilkan pesan sukses menggunakan SweetAlert2
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success'
                        });
                    } else {
                        // Tampilkan pesan error jika update gagal
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(error) {
                    // Tampilkan pesan error jika terjadi kesalahan AJAX
                    Swal.fire({
                        title: 'Error!',
                        text: error.responseJSON?.message || error.message,
                        icon: 'error'
                    });
                }
            });
        });

        // Event saat modal edit ditutup, bersihkan nilai input
        jQuery('#editModal').on('hidden.bs.modal', function() {
            // Bersihkan nilai input dalam modal
            $('#editIdLanding').val('');
            $('#editInputJudul').val('');
            $('#editInputDeskripsi').val('');
            $('#editInputLanding').val('');
            $('#editCurrentImage').attr('src', ''); // Kosongkan landing saat ini
        });
    });
</script>
<?= $this->endSection() ?>