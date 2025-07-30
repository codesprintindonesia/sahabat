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
        <table id="kategoriDatatable" class="table hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody></tbody> <!-- Data tabel akan diisi melalui AJAX -->
        </table>
    </div>

    <!-- Modal Form Edit Kategori -->
    <div class="modal fade text-start" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">Edit Kategori</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editNamaKategori">Nama:</label>
                        <input type="hidden" class="form-control" id="editIdKategori">
                        <input type="text" class="form-control" id="editNamaKategori" placeholder="Masukkan Nama Kategori">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="updateKategori">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah Kategori -->
    <div class="modal fade text-start" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">Tambah Kategori</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputNamaKategori">Nama:</label>
                        <input type="text" class="form-control" id="inputNamaKategori" placeholder="Masukkan Nama Kategori">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="tambahKategori">Simpan</button>
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
        // jQuery('#kategoriDatatable').DataTable();

        // Fungsi untuk mengambil dan menampilkan data kategori
        function loadKategoriData() {
            $.ajax({
                url: '<?= base_url('master/kategori/find_all') ?>', // Ganti dengan URL endpoint API yang mengembalikan data kategori dalam format JSON
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Menghapus DataTable yang ada
                    jQuery('#kategoriDatatable').DataTable().destroy();
                    // Mengosongkan tabel sebelum mengisi data baru
                    $('#kategoriDatatable tbody').empty();

                    // Mengisi tabel dengan data kategori
                    $.each(response.data, function(index, kategori) {
                        $('#kategoriDatatable tbody').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${kategori.nama}</td>
                            <td class="text-center">
                                <button class="button button-border-thin button-border button-amber button-small button-edit" data-id="${kategori.id}">Edit</button>
                                <button class="button button-border-thin button-border button-red button-small button-delete" data-id="${kategori.id}">Delete</button>
                            </td>
                        </tr>
                    `);
                    });

                    jQuery('#kategoriDatatable').DataTable();

                },
                error: function(error) {
                    console.error('Terjadi kesalahan saat mengambil data kategori:', error);
                }
            });
        }

        // Memanggil fungsi loadKategoriData saat halaman pertama kali dimuat
        loadKategoriData();

        // Event saat tombol "Tambah Kategori" ditekan
        $('#tambahKategori').on('click', function() {
            var namaKategori = $('#inputNamaKategori').val();

            // Kirim data ke server untuk tambah data menggunakan AJAX
            $.ajax({
                url: '<?= base_url('master/kategori/create') ?>', // Sesuaikan dengan endpoint API untuk menambahkan data kategori
                type: 'POST',
                data: {
                    nama: namaKategori
                },
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Tutup modal jika tambah data berhasil
                        jQuery('#addModal').modal('hide');

                        // Bersihkan nilai input dalam modal
                        $('#inputNamaKategori').val('');

                        // Tampilkan pesan sukses menggunakan SweetAlert2
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success'
                        });

                        // Refresh halaman atau muat ulang data kategori jika diperlukan
                        loadKategoriData();
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
            console.log('button delete clicked');
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
                        url: '<?= base_url('master/kategori/delete/') ?>' + categoryId,
                        type: 'DELETE',
                        success: function(response) {
                            // Tampilkan pesan sukses menggunakan SweetAlert2
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success'
                            });

                            // Memuat ulang data tabel setelah operasi selesai
                            loadKategoriData();
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

        // Event click pada tombol "Edit" di tabel
        $(document).on("click", ".button-edit", function() {
            let categoryId = $(this).data('id');

            // Ambil data dari server menggunakan AJAX dan isi formulir modal
            $.ajax({
                url: '<?= base_url('master/kategori/find_by_id/') ?>' + categoryId, // Sesuaikan dengan endpoint API untuk mendapatkan data kategori berdasarkan ID
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Isi formulir modal dengan data dari server 
                        $('#editIdKategori').val(response.data.id);
                        $('#editNamaKategori').val(response.data.nama);

                        // Tampilkan modal
                        jQuery('#editModal').modal('show');
                    } else {
                        // Tampilkan pesan error jika gagal mengambil data
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengambil data kategori.',
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

        // Event click pada tombol "Simpan Perubahan" di modal
        $(document).on("click", "#updateKategori", function() {
            let categoryIdKategori = $('#editIdKategori').val();
            let newNamaKategori = $('#editNamaKategori').val();

            // Kirim data ke server untuk update menggunakan AJAX
            $.ajax({
                url: '<?= base_url('master/kategori/update') ?>', // Sesuaikan dengan endpoint API untuk melakukan update data kategori berdasarkan ID
                type: 'POST',
                data: {
                    id: categoryIdKategori,
                    nama: newNamaKategori
                },
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Tutup modal jika update berhasil
                        jQuery('#editModal').modal('hide');

                        // Bersihkan nilai input dalam modal
                        $('#editIdKategori').val('');
                        $('#editNamaKategori').val('');

                        // Memuat ulang data tabel setelah operasi selesai
                        loadKategoriData();

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
        jQuery('#addModal').on('hidden.bs.modal', function() {
            $('#inputNamaKategori').val('');
        });

        // Event saat modal tertutup
        jQuery('#editModal').on('hidden.bs.modal', function() {
            // Bersihkan nilai input dalam modal
            $('#editIdKategori').val('');
            $('#editNamaKategori').val('');
        });

    });
</script>
<?= $this->endSection() ?>