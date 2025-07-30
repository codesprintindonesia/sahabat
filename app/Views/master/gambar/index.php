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
        <table id="gambarDatatable" class="table hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Judul</th>
                    <!-- <th>Deskripsi</th> -->
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Judul</th>
                    <!-- <th>Deskripsi</th> -->
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody></tbody> <!-- Data tabel akan diisi melalui AJAX -->
        </table>
    </div>

    <!-- Modal Form Edit Gambar -->
    <div class="modal fade text-start" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">Edit Gambar</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditGambar" enctype="multipart/form-data">
                        <input type="hidden" id="editIdGambar" name="editIdGambar">
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
                            <textarea class="form-control tiny-area" id="editInputDeskripsi" placeholder="Masukkan Deskripsi">Disini</textarea>
                        </div>
                        <div class="form-group">
                            <label for="editInputGambar">Gambar Baru:</label>
                            <input type="file" class="form-control" id="editInputGambar" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="editCurrentImage">Gambar Saat Ini:</label>
                            <img src="" id="editCurrentImage" class="img-fluid form-control" style="width: 200px;" alt="Gambar Saat Ini">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="updateGambar">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah Gambar -->
    <div class="modal fade text-start" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Tambah Gambar</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahGambar" enctype="multipart/form-data">
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
                            <textarea class="form-control tiny-area" id="inputDeskripsi" placeholder="Masukkan Deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputGambar">Gambar:</label>
                            <input type="file" class="form-control" id="inputGambar" style="width: 200px;" accept="image/*" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="tambahGambar">Simpan</button>
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

<!-- TinyMCE Plugin -->
<script src="<?= base_url() ?>public/js/components/tinymce/tinymce.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {

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

        // Fungsi untuk mengambil dan menampilkan data gambar
        function loadGambarData() {
            $.ajax({
                url: '<?= base_url('master/gambar/find_all') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Menghapus DataTable yang ada
                    jQuery('#gambarDatatable').DataTable().destroy();
                    // Mengosongkan tabel sebelum mengisi data baru
                    $('#gambarDatatable tbody').empty();

                    // Mengisi tabel dengan data gambar
                    $.each(response.data, function(index, gambar) {
                        $('#gambarDatatable tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${gambar.item_nama}</td>
                                <td>${gambar.judul}</td> 
                                <td><img src="<?= base_url('/public/uploads/gambar/thumbnail/') ?>${gambar.filename}" class="img-fluid" width="100" height="100" alt="Gambar"></td>
                                <td class="text-center">
                                    <button class="button button-border-thin button-border button-amber button-small button-edit" data-id="${gambar.id}">Edit</button>
                                    <button class="button button-border-thin button-border button-red button-small button-delete" data-id="${gambar.id}">Delete</button>
                                </td>
                            </tr>
                        `);
                    });

                    jQuery('#gambarDatatable').DataTable();
                },
                error: function(error) {
                    console.error('Terjadi kesalahan saat mengambil data gambar:', error);
                }
            });
        }

        // Memanggil fungsi loadGambarData saat halaman pertama kali dimuat
        loadGambarData();

        // Event saat tombol "Simpan" pada modal ditekan
        $(document).on('click', '#tambahGambar', function() {
            let itemId = $('#inputItemId').val();
            let judul = $('#inputJudul').val();
            // let deskripsi = $('#inputDeskripsi').val();            
            let deskripsi = tinymce.get('inputDeskripsi').getContent();
            let gambarFile = $('#inputGambar')[0].files[0];

            // Buat objek FormData untuk mengirim data yang lebih kompleks termasuk file
            let formData = new FormData();
            formData.append('item_id', itemId);
            formData.append('judul', judul);
            formData.append('deskripsi', deskripsi);
            formData.append('gambar', gambarFile);

            // Kirim data ke server untuk tambah data menggunakan AJAX
            $.ajax({
                url: '<?= base_url('master/gambar/create') ?>',
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
                        tinymce.get('inputDeskripsi').setContent('');
                        $('#inputGambar').val('');

                        // Tampilkan pesan sukses menggunakan SweetAlert2
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success'
                        });

                        // Refresh halaman atau muat ulang data gambar jika diperlukan
                        loadGambarData();
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
                        url: '<?= base_url('master/gambar/delete/') ?>' + categoryId,
                        type: 'DELETE',
                        success: function(response) {
                            // Tampilkan pesan sukses menggunakan SweetAlert2
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success'
                            });

                            // Memuat ulang data tabel setelah operasi selesai
                            loadGambarData();
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
            $('#inputNamaGambar').val('');
            $('#inputGambar').val('');
        });

        // Event saat pengguna memilih gambar baru di modal edit
        $(document).on('change', '#editInputGambar', function() {
            let inputGambar = this;
            if (inputGambar.files && inputGambar.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#editCurrentImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(inputGambar.files[0]);
            }
        });

        // Event click pada tombol "Edit" di tabel
        $(document).on("click", ".button-edit", function() {
            let gambarId = $(this).data('id');

            // Ambil data dari server menggunakan AJAX dan isi formulir modal
            $.ajax({
                url: '<?= base_url('master/gambar/find_by_id/') ?>' + gambarId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Isi formulir modal dengan data dari server 
                        $('#editIdGambar').val(response.data.id);
                        $('#editInputJudul').val(response.data.judul);
                        // $('#editInputDeskripsi').val(response.data.deskripsi);
                        tinymce.get('editInputDeskripsi').setContent(response.data.deskripsi);

                        // Tampilkan nama kategori dan item
                        $('#editKategoriName').val(response.data.kategori_nama);
                        $('#editItemName').val(response.data.item_nama);

                        // Tampilkan gambar saat ini
                        $('#editCurrentImage').attr('src', '<?= base_url('/public/uploads/gambar/thumbnail/') ?>' + response.data.filename);

                        // Reset input gambar baru
                        $('#editInputGambar').val('');

                        // Tampilkan modal
                        jQuery('#editModal').modal('show');
                    } else {
                        // Tampilkan pesan error jika gagal mengambil data
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengambil data gambar.',
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
        $(document).on("click", "#updateGambar", function() {
            // Ambil data dari formulir modal
            let gambarId = $('#editIdGambar').val();
            let newJudul = $('#editInputJudul').val();
            // let newDeskripsi = $('#editInputDeskripsi').val();
            let newDeskripsi = tinymce.get('editInputDeskripsi').getContent();
            let newGambar = $('#editInputGambar')[0].files[0];

            // Kirim data ke server untuk update menggunakan FormData
            let formData = new FormData();
            formData.append('id', gambarId);
            formData.append('judul', newJudul);
            formData.append('deskripsi', newDeskripsi);
            formData.append('gambar', newGambar);

            $.ajax({
                url: '<?= base_url('master/gambar/update') ?>',
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
                        $('#editIdGambar').val('');
                        $('#editInputJudul').val('');
                        // $('#editInputDeskripsi').val('');
                        tinymce.get('editInputDeskripsi').setContent('');
                        $('#editInputGambar').val('');
                        $('#editCurrentImage').attr('src', ''); // Kosongkan gambar saat ini

                        // Memuat ulang data tabel setelah operasi selesai
                        loadGambarData();

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
            $('#editIdGambar').val('');
            $('#editInputJudul').val('');
            // $('#editInputDeskripsi').val('');
            tinymce.get('editInputDeskripsi').setContent('');
            $('#editInputGambar').val('');
            $('#editCurrentImage').attr('src', ''); // Kosongkan gambar saat ini
        });

        tinymce.init({
            selector: '.tiny-area',
            promotion: false,
            menubar: false
        });
    });
</script>
<?= $this->endSection() ?>