<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="">
    <div class="row">
        <h3><?= $title ?></h3>
        <hr>
    </div>
    <div class="row">
        <div class="col-auto ms-auto">
            <button class="button button-border-thin button-border button-blue button-small" data-bs-toggle="modal" data-bs-target="#addVideoModal">Tambah</button>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table id="videoDatatable" class="table hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Video</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Video</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody></tbody> <!-- Data tabel akan diisi melalui AJAX -->
        </table>
    </div>

    <!-- Modal Form Tambah Video -->
    <div class="modal fade text-start" id="addVideoModal" tabindex="-1" role="dialog" aria-labelledby="addVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addVideoModalLabel">Tambah Video</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahVideo" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputKategori">Kategori:</label>
                            <select class="form-control" id="inputKategori" required>
                                <!-- Option-kategori diisi melalui JavaScript saat mendapatkan data kategori dari server -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputItemId">Item:</label>
                            <select class="form-control" id="inputItemId" required>
                                <!-- Option-items diisi dinamis melalui JavaScript saat mendapatkan data item dari server -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputJudul">Judul:</label>
                            <input type="text" class="form-control" id="inputJudul" placeholder="Masukkan Judul" required>
                        </div>
                        <div class="form-group">
                            <label for="inputDeskripsi">Deskripsi:</label>
                            <textarea class="form-control" id="inputDeskripsi" placeholder="Masukkan Deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputVideo">Video:</label>
                            <input type="file" class="form-control" id="inputVideo" accept="video/*" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="tambahVideo">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Edit Video -->
    <div class="modal fade text-start" id="editVideoModal" tabindex="-1" role="dialog" aria-labelledby="editVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editVideoModalLabel">Edit Video</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditVideo" enctype="multipart/form-data">
                        <input type="hidden" id="editIdVideo" name="editIdVideo">
                        <div class="form-group">
                            <label for="editKategoriName">Kategori:</label>
                            <input type="text" class="form-control" id="editKategoriName" disabled>
                        </div>
                        <div class="form-group">
                            <label for="editItemName">Item:</label>
                            <input type="text" class="form-control" id="editItemName" disabled>
                        </div>
                        <div class="form-group">
                            <label for="editInputJudul">Judul:</label>
                            <input type="text" class="form-control" id="editInputJudul" placeholder="Masukkan Judul" required>
                        </div>
                        <div class="form-group">
                            <label for="editInputDeskripsi">Deskripsi:</label>
                            <textarea class="form-control" id="editInputDeskripsi" placeholder="Masukkan Deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editInputVideo">Video Baru:</label>
                            <input type="file" class="form-control" id="editInputVideo" accept="video/*">
                        </div>
                        <div class="form-group">
                            <label for="editCurrentVideo">Video Saat Ini:</label>
                            <video controls id="editCurrentVideo" class="form-control"></video>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="updateVideo">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {

        // Fungsi untuk mengambil dan menampilkan data video
        function loadVideoData() {
            $.ajax({
                url: '<?= base_url('Master/VideoLokal/find_all') ?>', // Ganti dengan URL endpoint API yang mengembalikan data video dalam format JSON
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Menghapus DataTable yang ada
                    jQuery('#videoDatatable').DataTable().destroy();
                    // Mengosongkan tabel sebelum mengisi data baru
                    $('#videoDatatable tbody').empty();

                    // Mengisi tabel dengan data video
                    $.each(response.data, function(index, video) {

                        $('#videoDatatable tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${video.item_nama}</td>
                                <td>${video.judul}</td>
                                <td>${video.deskripsi}</td> 
                                <td>
                                    <video style="width: 300px; height: 200px" class="d-block w-300" preload="auto" controls> 
                                        <source src="<?= base_url('public/uploads/videos/') ?>${video.filename}" type='video/mp4'>
                                    </video>
                                </td> 
                                <td class="text-center">
                                    <button class="button button-border button-border-thin button-amber button-small button-edit" data-id="${video.id}">Edit</button>
                                    <button class="button button-border button-border-thin button-red button-small button-delete" data-id="${video.id}">Delete</button>
                                </td>
                            </tr>
                            `);
                    });

                    // Inisialisasi datatables pada tabel
                    jQuery('#videoDatatable').DataTable();
                },
                error: function(error) {
                    console.error('Terjadi kesalahan saat mengambil data video:', error);
                }
            });
        }

        // Memanggil fungsi loadVideoData saat halaman pertama kali dimuat
        loadVideoData();

        // Fungsi untuk mengambil dan mengisi opsi kategori dari server
        function loadCategories() {
            $.ajax({
                url: '<?= base_url('master/kategori/find_all') ?>', // Sesuaikan dengan endpoint API yang mengembalikan data kategori dalam format JSON
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Mengisi opsi kategori dengan data dari server
                    let selectElement = $('#inputKategori');
                    selectElement.empty(); // Menghapus opsi sebelum menambahkan yang baru

                    // Menambahkan opsi dari data kategori ke elemen <select>
                    selectElement.append('<option value="">Pilih Kategori</option>');
                    $.each(response.data, function(index, category) {
                        selectElement.append('<option value="' + category.id + '">' + category.nama + '</option>');
                    });

                    // Memanggil fungsi untuk mengisi opsi items saat opsi kategori dipilih
                    selectElement.change(function() {
                        let categoryId = $(this).val();
                        loadItemsByCategory(categoryId);
                    });
                },
                error: function(error) {
                    console.error('Terjadi kesalahan saat mengambil data kategori:', error);
                }
            });
        }

        // Fungsi untuk mengambil dan mengisi opsi items berdasarkan kategori dari server
        function loadItemsByCategory(categoryId) {
            $.ajax({
                url: '<?= base_url('master/item/find_by_category_id/') ?>' + categoryId, // Sesuaikan dengan endpoint API yang mengembalikan data item berdasarkan kategori dalam format JSON
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Mengisi opsi items dengan data dari server
                    let itemSelectElement = $('#inputItemId');
                    itemSelectElement.empty(); // Menghapus opsi sebelum menambahkan yang baru

                    // Menambahkan opsi dari data items ke elemen <select>
                    itemSelectElement.append('<option value="">Pilih Item</option>');
                    $.each(response.data, function(index, item) {
                        itemSelectElement.append('<option value="' + item.id + '">' + item.nama + '</option>');
                    });
                },
                error: function(error) {
                    console.error('Terjadi kesalahan saat mengambil data item berdasarkan kategori:', error);
                }
            });
        }

        // Memanggil fungsi untuk mengisi opsi kategori saat dokumen siap
        loadCategories();

        // Event saat tombol "Tambah Video" ditekan 
        $(document).on('click', '#tambahVideo', function() {
            let itemId = $('#inputItemId').val();
            let judul = $('#inputJudul').val();
            let deskripsi = $('#inputDeskripsi').val();
            let videoFile = $('#inputVideo')[0].files[0];

            // Buat objek FormData untuk mengirim data yang lebih kompleks termasuk file
            let formData = new FormData();
            formData.append('item_id', itemId);
            formData.append('judul', judul);
            formData.append('deskripsi', deskripsi);
            formData.append('video', videoFile);

            // Kirim data ke server untuk tambah data menggunakan AJAX
            $.ajax({
                url: '<?= base_url('Master/VideoLokal/create') ?>',
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
                        $('#inputVideo').val('');

                        // Tampilkan pesan sukses menggunakan SweetAlert2
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success'
                        });

                        // Refresh halaman atau muat ulang data video jika diperlukan
                        loadVideoData();
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

        // Event saat tombol "Delete" pada tabel ditekan
        $(document).on('click', '.button-delete', function() {
            let videoId = $(this).data('id');

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
                if (result.isConfirmed) {
                    // Kirim permintaan DELETE ke server
                    $.ajax({
                        url: '<?= base_url('Master/VideoLokal/delete/') ?>' + videoId,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.code == 200) {
                                // Tampilkan pesan sukses menggunakan SweetAlert2
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.message,
                                    icon: 'success'
                                });
                            } else {
                                // Tampilkan pesan error jika menghapus data gagal
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }

                            // Memuat ulang data tabel setelah operasi selesai
                            loadVideoData();
                        },
                        error: function(error) {
                            // Tampilkan pesan error jika terjadi kesalahan AJAX
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

        // Event saat pengguna memilih gambar baru di modal edit
        $(document).on('change', '#editInputVideo', function() {
            let inputVideo = this;
            if (inputVideo.files && inputVideo.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#editCurrentVideo').attr('src', e.target.result);
                };
                reader.readAsDataURL(inputVideo.files[0]);
            }
        });

        $(document).on("click", ".button-edit", function() {
            let videoId = $(this).data('id');
            // Ambil data dari server menggunakan AJAX dan isi formulir modal
            $.ajax({
                url: '<?= base_url('Master/VideoLokal/find_by_id/') ?>' + videoId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Isi formulir modal dengan data dari server 
                        $('#editIdVideo').val(response.data.id);
                        $('#editInputJudul').val(response.data.judul);
                        $('#editInputDeskripsi').val(response.data.deskripsi);

                        // Tampilkan nama kategori dan item
                        $('#editKategoriName').val(response.data.kategori_nama);
                        $('#editItemName').val(response.data.item_nama);

                        // Tampilkan video saat ini
                        $('#editCurrentVideo').attr('src', '<?= base_url('/public/uploads/videos/') ?>' + response.data.filename);

                        // Reset input video baru
                        $('#editInputVideo').val('');

                        // Tampilkan modal
                        jQuery('#editVideoModal').modal('show');
                    } else {
                        // Tampilkan pesan error jika gagal mengambil data
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengambil data video.',
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


        // Event click pada tombol "Simpan Perubahan" di modal Edit Video
        $(document).on("click", "#updateVideo", function() {
            // Ambil data dari formulir modal
            let videoId = $('#editIdVideo').val();
            let newJudul = $('#editInputJudul').val();
            let newDeskripsi = $('#editInputDeskripsi').val();
            let newVideo = $('#editInputVideo')[0].files[0];

            // Kirim data ke server untuk update menggunakan FormData
            let formData = new FormData();
            formData.append('id', videoId);
            formData.append('judul', newJudul);
            formData.append('deskripsi', newDeskripsi);
            formData.append('video', newVideo);

            $.ajax({
                url: '<?= base_url('Master/VideoLokal/update') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.code == 200) {
                        // Tutup modal jika update berhasil
                        jQuery('#editVideoModal').modal('hide');

                        // Bersihkan nilai input dalam modal
                        $('#editIdVideo').val('');
                        $('#editInputJudul').val('');
                        $('#editInputDeskripsi').val('');
                        $('#editInputVideo').val('');
                        $('#editCurrentImage').attr('src', ''); // Kosongkan video saat ini

                        // Memuat ulang data tabel setelah operasi selesai
                        loadVideoData();

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

        // Event saat modal ditutup, bersihkan formulir modal
        $('#addVideoModal').on('hidden.bs.modal', function() {
            $('#inputNamaVideo').val('');
            $('#inputVideo').val('');
        });

        // Event saat modal ditutup, bersihkan formulir modal
        $('#editVideoModal').on('hidden.bs.modal', function() {
            // Bersihkan nilai input dalam modal
            $('#editIdVideo').val('');
            $('#editInputJudul').val('');
            $('#editInputDeskripsi').val('');
            $('#editInputVideo').val('');
            $('#editCurrentVideo').attr('src', '');
        });

    });
</script>
<?= $this->endSection() ?>