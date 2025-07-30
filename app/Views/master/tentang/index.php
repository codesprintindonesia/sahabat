<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="">
    <div class="row">
        <h3><?= $title ?></h3>
        <hr>
    </div>
    <div class="row">
        <div class="col-auto ms-auto">
            <button class="button button-border-thin button-border button-blue button-small" data-bs-toggle="modal" data-bs-target="#addModal">Tambah</button>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table id="tentangDatatable" class="table hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Tentang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Tentang</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody></tbody> <!-- Data tabel akan diisi melalui AJAX -->
        </table>
    </div>

    <!-- Modal Form Edit Tentang -->
    <div class="modal fade text-start" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">Edit Tentang</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditTentang" enctype="multipart/form-data">
                        <input type="hidden" id="editIdTentang" name="editIdTentang">
                        <div class="form-group">
                            <label for="editInputJudul">Judul:</label>
                            <input type="text" class="form-control" id="editInputJudul" placeholder="Masukkan Judul" required>
                        </div>
                        <div class="form-group">
                            <label for="editInputDeskripsi">Deskripsi:</label>
                            <textarea class="form-control" id="editInputDeskripsi" placeholder="Masukkan Deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editInputTentang">Tentang Baru:</label>
                            <input type="file" class="form-control" id="editInputTentang" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="editCurrentImage">Tentang Saat Ini:</label>
                            <img src="" id="editCurrentImage" class="img-fluid form-control" alt="Tentang Saat Ini">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="updateTentang">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah Tentang -->
    <div class="modal fade text-start" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Tambah Tentang</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahTentang" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputJudul">Judul:</label>
                            <input type="text" class="form-control" id="inputJudul" placeholder="Masukkan Judul" required>
                        </div>
                        <div class="form-group">
                            <label for="inputDeskripsi">Deskripsi:</label>
                            <textarea class="form-control" id="inputDeskripsi" placeholder="Masukkan Deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputTentang">Tentang:</label>
                            <input type="file" class="form-control" id="inputTentang" accept="image/*" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="tambahTentang">Simpan</button>
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

        // Fungsi untuk mengambil dan menampilkan data tentang
        function loadTentangData() {
            $.ajax({
                url: '<?= base_url('master/tentang/find_all') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Menghapus DataTable yang ada
                    jQuery('#tentangDatatable').DataTable().destroy();
                    // Mengosongkan tabel sebelum mengisi data baru
                    $('#tentangDatatable tbody').empty();

                    // Mengisi tabel dengan data tentang
                    $.each(response.data, function(index, tentang) {
                        $('#tentangDatatable tbody').append(`
                            <tr>
                                <td>${index + 1}</td> 
                                <td>${tentang.judul}</td>
                                <td>${tentang.deskripsi}</td>
                                <td><img src="<?= base_url('/public/uploads/tentang/thumbnail/') ?>${tentang.filename}" class="img-fluid" width="300" height="100" alt="Tentang"></td>
                                <td class="text-center">
                                    <button class="button button-border-thin button-border button-amber button-small button-edit" data-id="${tentang.id}">Edit</button>
                                    <button class="button button-border-thin button-border button-red button-small button-delete" data-id="${tentang.id}">Delete</button>
                                </td>
                            </tr>
                        `);
                    });

                    jQuery('#tentangDatatable').DataTable();
                },
                error: function(error) {
                    console.error('Terjadi kesalahan saat mengambil data tentang:', error);
                }
            });
        }

        // Memanggil fungsi loadTentangData saat halaman pertama kali dimuat
        loadTentangData();

        // Event saat tombol "Simpan" pada modal ditekan
        $(document).on('click', '#tambahTentang', function() {
            let judul = $('#inputJudul').val();
            let deskripsi = $('#inputDeskripsi').val();
            let tentangFile = $('#inputTentang')[0].files[0];

            // Buat objek FormData untuk mengirim data yang lebih kompleks termasuk file
            let formData = new FormData();
            formData.append('judul', judul);
            formData.append('deskripsi', deskripsi);
            formData.append('tentang', tentangFile);

            // Kirim data ke server untuk tambah data menggunakan AJAX
            $.ajax({
                url: '<?= base_url('master/tentang/create') ?>',
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
                        $('#inputTentang').val('');

                        // Tampilkan pesan sukses menggunakan SweetAlert2
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success'
                        });

                        // Refresh halaman atau muat ulang data tentang jika diperlukan
                        loadTentangData();
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
                        url: '<?= base_url('master/tentang/delete/') ?>' + categoryId,
                        type: 'DELETE',
                        success: function(response) {
                            // Tampilkan pesan sukses menggunakan SweetAlert2
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success'
                            });

                            // Memuat ulang data tabel setelah operasi selesai
                            loadTentangData();
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
            $('#inputNamaTentang').val('');
            $('#inputTentang').val('');
        });

        // Event saat pengguna memilih tentang baru di modal edit
        $(document).on('change', '#editInputTentang', function() {
            let inputTentang = this;
            if (inputTentang.files && inputTentang.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#editCurrentImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(inputTentang.files[0]);
            }
        });

        // Event click pada tombol "Edit" di tabel
        $(document).on("click", ".button-edit", function() {
            let tentangId = $(this).data('id');

            // Ambil data dari server menggunakan AJAX dan isi formulir modal
            $.ajax({
                url: '<?= base_url('master/tentang/find_by_id/') ?>' + tentangId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Isi formulir modal dengan data dari server 
                        $('#editIdTentang').val(response.data.id);
                        $('#editInputJudul').val(response.data.judul);
                        $('#editInputDeskripsi').val(response.data.deskripsi);

                        // Tampilkan tentang saat ini
                        $('#editCurrentImage').attr('src', '<?= base_url('/public/uploads/tentang/thumbnail/') ?>' + response.data.filename);

                        // Reset input tentang baru
                        $('#editInputTentang').val('');

                        // Tampilkan modal
                        jQuery('#editModal').modal('show');
                    } else {
                        // Tampilkan pesan error jika gagal mengambil data
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengambil data tentang.',
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
        $(document).on("click", "#updateTentang", function() {
            // Ambil data dari formulir modal
            let tentangId = $('#editIdTentang').val();
            let newJudul = $('#editInputJudul').val();
            let newDeskripsi = $('#editInputDeskripsi').val();
            let newTentang = $('#editInputTentang')[0].files[0];

            // Kirim data ke server untuk update menggunakan FormData
            let formData = new FormData();
            formData.append('id', tentangId);
            formData.append('judul', newJudul);
            formData.append('deskripsi', newDeskripsi);
            formData.append('tentang', newTentang);

            $.ajax({
                url: '<?= base_url('master/tentang/update') ?>',
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
                        $('#editIdTentang').val('');
                        $('#editInputJudul').val('');
                        $('#editInputDeskripsi').val('');
                        $('#editInputTentang').val('');
                        $('#editCurrentImage').attr('src', ''); // Kosongkan tentang saat ini

                        // Memuat ulang data tabel setelah operasi selesai
                        loadTentangData();

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
            $('#editIdTentang').val('');
            $('#editInputJudul').val('');
            $('#editInputDeskripsi').val('');
            $('#editInputTentang').val('');
            $('#editCurrentImage').attr('src', ''); // Kosongkan tentang saat ini
        });
    });
</script>
<?= $this->endSection() ?>