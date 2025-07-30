<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="">
    <div class="row">
        <h3><?= $title ?></h3>
        <hr>
    </div>
    <div class="row">
        <div class="col-auto ms-auto">
            <button class="button button-border button-border-thin button-blue button-small" data-bs-toggle="modal" data-bs-target="#addVideoModal">Tambah</button>
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
                    <th>Link</th>
                    <th>Preview</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Link</th>
                    <th>Preview</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody></tbody> <!-- Data tabel akan diisi melalui AJAX -->
        </table>
    </div>

    <!-- Modal Form Tambah Video -->
    <div class="modal fade" id="addVideoModal" tabindex="-1" role="dialog" aria-labelledby="addVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addVideoModalLabel">Tambah Video</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
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
                        <input type="text" class="form-control" id="inputJudul" placeholder="Masukkan Judul Video" required>
                    </div>
                    <div class="form-group">
                        <label for="inputDeskripsi">Deskripsi:</label>
                        <textarea class="form-control" id="inputDeskripsi" placeholder="Masukkan Deskripsi Video"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputLink">Link Video:</label>
                        <input type="text" class="form-control" id="inputLink" placeholder="Masukkan Link Video" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border button-border-thin button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border button-border-thin button-blue button-small" id="tambahVideo">Simpan</button>
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
                    <div class="form-group">
                        <label for="editKategoriName">Kategori:</label>
                        <input type="text" class="form-control" id="editKategoriName" disabled>
                    </div>
                    <div class="form-group">
                        <label for="editItemName">Item:</label>
                        <input type="text" class="form-control" id="editItemName" disabled>
                    </div>
                    <div class="form-group">
                        <label for="editJudul">Judul:</label>
                        <input type="hidden" class="form-control" id="editIdVideo">
                        <input type="text" class="form-control" id="editJudul" placeholder="Masukkan Judul Video" required>
                    </div>
                    <div class="form-group">
                        <label for="editDeskripsi">Deskripsi:</label>
                        <textarea class="form-control" id="editDeskripsi" placeholder="Masukkan Deskripsi Video"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editLink">Link Video:</label>
                        <input type="text" class="form-control" id="editLink" placeholder="Masukkan Link Video" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border button-border-thin button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border button-border-thin button-blue button-small" id="updateVideo">Simpan</button>
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
                url: '<?= base_url('Master/VideoYoutube/find_all') ?>', // Ganti dengan URL endpoint API yang mengembalikan data video dalam format JSON
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
                        <td><a href="${video.link}" target="_blank">${video.link}</a></td>
                        <td>
                            <iframe width="560" height="100" src="${video.preview}" frameborder="0" allowfullscreen></iframe>
                        </td>
                        <td class="text-center">
                            <button class="button button-border button-border-thin button-amber button-small button-edit" data-id="${video.id}">Edit</button>
                            <button class="button button-border button-border-thin button-red button-small button-delete" data-id="${video.id}">Delete</button>
                        </td>
                    </tr>
                `);
                    });

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
                    var selectElement = $('#inputKategori');
                    selectElement.empty(); // Menghapus opsi sebelum menambahkan yang baru

                    // Menambahkan opsi dari data kategori ke elemen <select>
                    selectElement.append('<option value="">Pilih Kategori</option>');
                    $.each(response.data, function(index, category) {
                        selectElement.append('<option value="' + category.id + '">' + category.nama + '</option>');
                    });

                    // Memanggil fungsi untuk mengisi opsi items saat opsi kategori dipilih
                    selectElement.change(function() {
                        var categoryId = $(this).val();
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
                    var itemSelectElement = $('#inputItemId');
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
        $('#tambahVideo').on('click', function() {
            // Ambil data dari input
            const itemId = $('#inputItemId').val();
            const judulVideo = $('#inputJudul').val();
            const deskripsiVideo = $('#inputDeskripsi').val();
            const linkVideo = $('#inputLink').val();

            // Kirim data ke server untuk tambah data video menggunakan AJAX
            $.ajax({
                url: '<?= base_url('Master/VideoYoutube/create') ?>', // Sesuaikan dengan endpoint API untuk menambahkan data video
                type: 'POST',
                data: {
                    item_id: itemId,
                    judul: judulVideo,
                    deskripsi: deskripsiVideo,
                    link: linkVideo
                },
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Tutup modal jika tambah data berhasil
                        jQuery('#addVideoModal').modal('hide');

                        // Bersihkan nilai input dalam modal
                        $('#inputItemId').val('');
                        $('#inputJudul').val('');
                        $('#inputDeskripsi').val('');
                        $('#inputLink').val('');

                        // Tampilkan pesan sukses menggunakan SweetAlert2
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success'
                        });

                        // Memuat ulang data tabel setelah operasi selesai
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
            const videoId = $(this).data('id');

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
                        url: '<?= base_url('Master/VideoYoutube/delete/') ?>' + videoId,
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
                                // Tampilkan pesan error jika hapus data gagal
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

        // Event click pada tombol "Edit" di tabel Video
        $(document).on("click", ".button-edit", function() {
            let videoId = $(this).data('id');

            // Ambil data dari server menggunakan AJAX dan isi formulir modal
            $.ajax({
                url: '<?= base_url('Master/VideoYoutube/find_by_id/') ?>' + videoId, // Sesuaikan dengan endpoint API untuk mendapatkan data video berdasarkan ID
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Isi formulir modal dengan data dari server 
                        $('#editIdVideo').val(response.data.id);
                        $('#editJudul').val(response.data.judul);
                        $('#editDeskripsi').val(response.data.deskripsi);
                        $('#editLink').val(response.data.link);

                        // Tampilkan nama kategori dan item
                        $('#editKategoriName').val(response.data.kategori_nama);
                        $('#editItemName').val(response.data.item_nama);

                        // Tampilkan modal
                        jQuery('#editVideoModal').modal('show');
                    } else {
                        // Tampilkan pesan error jika gagal mengambil data
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengambil data video.',
                            icon: 'error'
                        })
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
            let videoId = $('#editIdVideo').val();
            let newItemId = $('#editItem').val();
            let newJudul = $('#editJudul').val();
            let newDeskripsi = $('#editDeskripsi').val();
            let newLink = $('#editLink').val();

            // Kirim data ke server untuk update menggunakan AJAX
            $.ajax({
                url: '<?= base_url('Master/VideoYoutube/update') ?>', // Sesuaikan dengan endpoint API untuk melakukan update data video berdasarkan ID
                type: 'POST',
                data: {
                    id: videoId,
                    item_id: newItemId,
                    judul: newJudul,
                    deskripsi: newDeskripsi,
                    link: newLink
                },
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Tutup modal jika update berhasil
                        jQuery('#editVideoModal').modal('hide');

                        // Bersihkan nilai input dalam modal
                        $('#editIdVideo').val('');
                        $('#editItem').val('');
                        $('#editJudul').val('');
                        $('#editDeskripsi').val('');
                        $('#editLink').val('');

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
                error: function() {
                    // Tampilkan pesan error jika terjadi kesalahan AJAX
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengirim data untuk diperbarui.',
                        icon: 'error'
                    });
                }
            });
        });

        // Event saat modal ditutup, bersihkan nilai input
        jQuery('#addVideoModal').on('hidden.bs.modal', function() {
            // Bersihkan nilai input dalam modal 
            $('#inputItemId').val('');
            $('#inputJudul').val('');
            $('#inputDeskripsi').val('');
            $('#inputLink').val('');
        });

        // Event saat modal tertutup
        jQuery('#editVideoModal').on('hidden.bs.modal', function() {
            // Bersihkan nilai input dalam modal
            $('#editIdVideo').val('');
            $('#editItem').val('');
            $('#editJudul').val('');
            $('#editDeskripsi').val('');
            $('#editLink').val('');
        });

    });
</script>
<?= $this->endSection() ?>