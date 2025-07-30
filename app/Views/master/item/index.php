<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="">
    <div class="row">
        <h3><?= $title ?></h3>
        <hr>
    </div>
    <div class="row">
        <div class="col-auto ms-auto">
            <button class="button button-border-thin button-border button-small button-blue" data-bs-toggle="modal" data-bs-target="#addItemModal">Tambah</button>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table id="itemDatatable" class="table hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody></tbody> <!-- Data tabel akan diisi melalui AJAX -->
        </table>
    </div>

    <!-- Modal Form Tambah Item -->
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addItemModalLabel">Tambah Item</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputKategori">Kategori:</label>
                        <select class="form-control" id="inputKategori" required>
                            <!-- Opsi kategori akan dimuat melalui AJAX -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputNamaItem">Nama:</label>
                        <input type="text" class="form-control" id="inputNamaItem" placeholder="Masukkan Nama Item" required>
                    </div>
                    <div class="form-group">
                        <label for="inputGambar">Gambar:</label>
                        <input type="file" class="form-control" id="inputGambar" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-small button-red" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-small button-blue" id="tambahItem">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Edit Item -->
    <div class="modal fade text-start" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editItemModalLabel">Edit Item</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editKategori">Kategori:</label>
                        <select class="form-control" id="editKategoriItem" required>
                            <!-- Opsi kategori akan dimuat melalui AJAX -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editNamaItem">Nama:</label>
                        <input type="hidden" class="form-control" id="editIdItem">
                        <input type="text" class="form-control" id="editNamaItem" placeholder="Masukkan Nama Item" required>
                    </div>
                    <div class="form-group">
                        <label for="editInputGambar">Gambar Baru:</label>
                        <input type="file" class="form-control" id="editInputGambar" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="editCurrentImage">Gambar Saat Ini:</label>
                        <img src="" id="editCurrentImage" class="img-fluid form-control" alt="Gambar Saat Ini">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-small button-red" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-small button-blue" id="updateItem">Simpan</button>
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

        // Fungsi untuk mengambil dan menampilkan data item
        function loadItemData() {
            $.ajax({
                url: '<?= base_url('master/item/find_all') ?>', // Ganti dengan URL endpoint API yang mengembalikan data item dalam format JSON
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Menghapus DataTable yang ada
                    jQuery('#itemDatatable').DataTable().destroy();
                    // Mengosongkan tabel sebelum mengisi data baru
                    $('#itemDatatable tbody').empty();

                    // Mengisi tabel dengan data item
                    $.each(response.data, function(index, item) {
                        $('#itemDatatable tbody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.kategori}</td>
                                <td>${item.nama}</td>
                                <td><img src="<?= base_url('/public/uploads/item/thumbnail/') ?>${item.filename}" class="img-fluid" width="100" height="100" alt="Gambar"></td>
                                <td class="text-center">
                                    <button class="button button-border-thin button-border button-small button-amber button-edit" data-id="${item.id}">Edit</button>
                                    <button class="button button-border-thin button-border button-small button-red button-delete" data-id="${item.id}">Delete</button>
                                </td>
                            </tr>
                        `);
                    });

                    jQuery('#itemDatatable').DataTable();
                },
                error: function(error) {
                    console.error('Terjadi kesalahan saat mengambil data item:', error);
                }
            });
        }

        // Memanggil fungsi loadItemData saat halaman pertama kali dimuat
        loadItemData();

        // Fungsi untuk mengambil dan menampilkan data kategori
        function loadKategoriOptions() {
            $.ajax({
                url: '<?= base_url('master/kategori/find_all') ?>', // Ganti dengan endpoint API yang mengembalikan data kategori dalam format JSON
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const kategoriDropdown = $('#inputKategori');
                    kategoriDropdown.empty();
                    kategoriDropdown.append('<option value="" disabled selected>Pilih Kategori</option>');
                    $.each(response.data, function(index, kategori) {
                        kategoriDropdown.append('<option value="' + kategori.id + '">' + kategori.nama + '</option>');
                    });

                    const editKategoriDropdown = $('#editKategoriItem');
                    editKategoriDropdown.empty();
                    editKategoriDropdown.append('<option value="" disabled selected>Pilih Kategori</option>');
                    $.each(response.data, function(index, kategori) {
                        editKategoriDropdown.append('<option value="' + kategori.id + '">' + kategori.nama + '</option>');
                    });
                },
                error: function(error) {
                    console.error('Terjadi kesalahan saat mengambil data kategori:', error);
                }
            });
        }

        // Memanggil fungsi loadKategoriOptions saat halaman pertama kali dimuat
        loadKategoriOptions();

        // Event saat tombol "Tambah Item" ditekan
        $('#tambahItem').on('click', function() {
            // Ambil data dari input
            const kategoriId = $('#inputKategori').val();
            const namaItem = $('#inputNamaItem').val();
            let gambarFile = $('#inputGambar')[0].files[0];

            // Buat objek FormData untuk mengirim data yang lebih kompleks termasuk file
            let formData = new FormData();
            formData.append('kategori_id', kategoriId);
            formData.append('nama', namaItem);
            formData.append('gambar', gambarFile);

            // Kirim data ke server untuk tambah data item menggunakan AJAX
            $.ajax({
                url: '<?= base_url('master/item/create') ?>', // Sesuaikan dengan endpoint API untuk menambahkan data item
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false, // Diperlukan untuk mengirim data FormData
                processData: false, // Diperlukan untuk mengirim data FormData
                success: function(response) {
                    if (response.code == 200) {
                        // Tutup modal jika tambah data berhasil
                        jQuery('#addItemModal').modal('hide');

                        // Bersihkan nilai input dalam modal
                        $('#inputKategori').val('');
                        $('#inputNamaItem').val('');
                        $('#inputGambar').val('');

                        // Tampilkan pesan sukses menggunakan SweetAlert2
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success'
                        });

                        // Memuat ulang data tabel setelah operasi selesai
                        loadItemData();

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
            const itemId = $(this).data('id');

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
                        url: '<?= base_url('master/item/delete/') ?>' + itemId,
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
                                // Tampilkan pesan error jika tambah data gagal
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                            // Memuat ulang data tabel setelah operasi selesai
                            loadItemData();
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

        // Event click pada tombol "Edit" di tabel Item
        $(document).on("click", ".button-edit", function() {

            let itemId = $(this).data('id');

            // Ambil data dari server menggunakan AJAX dan isi formulir modal
            $.ajax({
                url: '<?= base_url('master/item/find_by_id/') ?>' + itemId, // Sesuaikan dengan endpoint API untuk mendapatkan data item berdasarkan ID
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response)
                    if (response.code == 200) {
                        // Isi formulir modal dengan data dari server 
                        $('#editIdItem').val(response.data.id);
                        $('#editNamaItem').val(response.data.nama);
                        $('#editKategoriItem').val(response.data.kategori_id);

                        // Tampilkan gambar saat ini
                        $('#editCurrentImage').attr('src', '<?= base_url('/public/uploads/gambar/thumbnail/') ?>' + response.data.filename);

                        // Reset input gambar baru
                        $('#editInputGambar').val('');

                        // Tampilkan modal
                        jQuery('#editItemModal').modal('show');
                    } else {
                        // Tampilkan pesan error jika gagal mengambil data
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengambil data item.',
                            icon: 'error'
                        })
                    }
                },
                error: function(error) {
                    // Tampilkan pesan error jika terjadi kesalahan AJAX 
                    console.log(error)
                    Swal.fire({
                        title: 'Error!',
                        text: error.responseJSON?.message || error.message,
                        icon: 'error'
                    });
                }
            });
        });

        // Event click pada tombol "Simpan Perubahan" di modal Edit Item
        $(document).on("click", "#updateItem", function() {
            let itemId = $('#editIdItem').val();
            let newNamaItem = $('#editNamaItem').val();
            let newKategoriItem = $('#editKategoriItem').val();
            let newGambar = $('#editInputGambar')[0].files[0];

            // Kirim data ke server untuk update menggunakan FormData
            let formData = new FormData();
            formData.append('id', itemId);
            formData.append('nama', newNamaItem);
            formData.append('kategori_id', newKategoriItem);
            formData.append('gambar', newGambar);

            $.ajax({
                url: '<?= base_url('master/item/update') ?>', // Sesuaikan dengan endpoint API untuk melakukan update data item berdasarkan ID
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.code == 200) {
                        // Tutup modal jika update berhasil
                        jQuery('#editItemModal').modal('hide');

                        // Bersihkan nilai input dalam modal
                        $('#editIdItem').val('');
                        $('#editNamaItem').val('');
                        $('#editKategoriItem').val('');
                        $('#editInputGambar').val('');
                        $('#editCurrentImage').attr('src', ''); // Kosongkan gambar saat ini

                        // Memuat ulang data tabel setelah operasi selesai
                        loadItemData();

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

        // Event saat modal ditutup, bersihkan nilai input
        jQuery('#addItemModal').on('hidden.bs.modal', function() {
            // Bersihkan nilai input dalam modal 
            $('#editNamaItem').val('');
            $('#editKategoriItem').val('');
            $('#inputGambar').val('');
        });

        // Event saat modal tertutup
        jQuery('#editItemModal').on('hidden.bs.modal', function() {
            // Bersihkan nilai input dalam modal
            $('#editIdItem').val('');
            $('#editNamaItem').val('');
            $('#editKategoriItem').val('');
            $('#editInputGambar').val('');
            $('#editCurrentImage').attr('src', ''); // Kosongkan gambar saat ini
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


    });
</script>
<?= $this->endSection() ?>