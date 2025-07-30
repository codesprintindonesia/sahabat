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
        <table id="penggunaDatatable" class="table hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Is Active</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Is Active</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody></tbody> <!-- Data tabel akan diisi melalui AJAX -->
        </table>
    </div>

    <!-- Modal Form Edit Pengguna -->
    <div class="modal fade text-start" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">Edit Pengguna</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editNama">Nama:</label>
                        <input type="hidden" class="form-control" id="editId">
                        <input type="text" class="form-control" id="editNama" placeholder="Masukkan Nama Pengguna">
                    </div>
                    <div class="form-group">
                        <label for="editUsername">Username:</label>
                        <input type="text" class="form-control" id="editUsername" placeholder="Masukkan Username Pengguna">
                    </div>
                    <div class="form-group">
                        <label for="editRole">Role:</label> 
                        <select class="form-control" id="editRole" placeholder="Masukkan Role Pengguna">
                            <option value="2">Admin</option>
                            <option value="1">Superadmin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editIsActive">Is Active:</label>
                        <select class="form-select" id="editIsActive">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="updatePengguna">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah Pengguna -->
    <div class="modal fade text-start" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Tambah Pengguna</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputNama">Nama:</label>
                        <input type="text" class="form-control" id="inputNama" placeholder="Masukkan Nama Pengguna">
                    </div>
                    <div class="form-group">
                        <label for="inputUsername">Username:</label>
                        <input type="text" class="form-control" id="inputUsername" placeholder="Masukkan Username Pengguna">
                    </div>
                    <div class="form-group">
                        <label for="inputRole">Role:</label> 
                        <select class="form-control" id="inputRole" placeholder="Masukkan Role Pengguna">
                            <option value="2">Admin</option>
                            <option value="1">Superadmin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputIsActive">Is Active:</label>
                        <select class="form-select" id="inputIsActive">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button button-border-thin button-border button-red button-small" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="button button-border-thin button-border button-blue button-small" id="tambahPengguna">Simpan</button>
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
        // Fungsi untuk mengambil dan menampilkan data pengguna
        function loadPenggunaData() {
            $.ajax({
                url: '<?= base_url('Master/Pengguna/find_all') ?>', // Ganti dengan URL endpoint API yang mengembalikan data pengguna dalam format JSON
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Menghapus DataTable yang ada
                    jQuery('#penggunaDatatable').DataTable().destroy();
                    // Mengosongkan tabel sebelum mengisi data baru
                    $('#penggunaDatatable tbody').empty();

                    // Mengisi tabel dengan data pengguna
                    $.each(response.data, function(index, pengguna) {
                        $('#penggunaDatatable tbody').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${pengguna.nama}</td>
                            <td>${pengguna.username}</td>
                            <td>${pengguna.role == 1 ? 'Superadmin' : 'Admin'}</td>
                            <td>${pengguna.is_active == 1 ? 'Aktif' : 'Tidak Aktif'}</td>
                            <td class="text-center">
                                <button class="button button-border-thin button-border button-amber button-small button-edit" data-id="${pengguna.id}">Edit</button>
                                <button class="button button-border-thin button-border button-red button-small button-delete" data-id="${pengguna.id}">Delete</button>
                            </td>
                        </tr>
                    `);
                    });

                    jQuery('#penggunaDatatable').DataTable();

                },
                error: function(error) {
                    console.error('Terjadi kesalahan saat mengambil data pengguna:', error);
                }
            });
        }

        // Memanggil fungsi loadPenggunaData saat halaman pertama kali dimuat
        loadPenggunaData();

        // Event saat tombol "Tambah Pengguna" ditekan
        $('#tambahPengguna').on('click', function() {
            var namaPengguna = $('#inputNama').val();
            var usernamePengguna = $('#inputUsername').val();
            var rolePengguna = $('#inputRole').val();
            var isActivePengguna = $('#inputIsActive').val();

            // Kirim data ke server untuk tambah data menggunakan AJAX
            $.ajax({
                url: '<?= base_url('master/pengguna/create') ?>', // Sesuaikan dengan endpoint API untuk menambahkan data pengguna
                type: 'POST',
                data: {
                    nama: namaPengguna,
                    username: usernamePengguna,
                    role: rolePengguna,
                    is_active: isActivePengguna
                },
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Tutup modal jika tambah data berhasil
                        jQuery('#addModal').modal('hide');

                        // Bersihkan nilai input dalam modal
                        $('#inputNama').val('');
                        $('#inputUsername').val('');
                        $('#inputRole').val('');
                        $('#inputIsActive').val('');

                        // Tampilkan pesan sukses menggunakan SweetAlert2
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success'
                        });

                        // Refresh halaman atau muat ulang data pengguna jika diperlukan
                        loadPenggunaData();
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

        // Fungsi AJAX untuk delete pengguna
        $(document).on('click', '.button-delete', function() {
            let userId = $(this).data('id');

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
                        url: '<?= base_url('master/pengguna/delete/') ?>' + userId,
                        type: 'DELETE',
                        success: function(response) {
                            // Tampilkan pesan sukses menggunakan SweetAlert2
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success'
                            });

                            // Memuat ulang data tabel setelah operasi selesai
                            loadPenggunaData();
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
            let userId = $(this).data('id');

            // Ambil data dari server menggunakan AJAX dan isi formulir modal
            $.ajax({
                url: '<?= base_url('master/pengguna/find_by_id/') ?>' + userId, // Sesuaikan dengan endpoint API untuk mendapatkan data pengguna berdasarkan ID
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Isi formulir modal dengan data dari server 
                        $('#editId').val(response.data.id);
                        $('#editNama').val(response.data.nama);
                        $('#editUsername').val(response.data.username);
                        $('#editRole').val(response.data.role);
                        $('#editIsActive').val(response.data.is_active);

                        // Tampilkan modal
                        jQuery('#editModal').modal('show');
                    } else {
                        // Tampilkan pesan error jika gagal mengambil data
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengambil data pengguna.',
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
        $(document).on("click", "#updatePengguna", function() {
            let userId = $('#editId').val();
            let newNama = $('#editNama').val();
            let newUsername = $('#editUsername').val();
            let newRole = $('#editRole').val();
            let newIsActive = $('#editIsActive').val();

            // Kirim data ke server untuk update menggunakan AJAX
            $.ajax({
                url: '<?= base_url('master/pengguna/update') ?>', // Sesuaikan dengan endpoint API untuk melakukan update data pengguna berdasarkan ID
                type: 'POST',
                data: {
                    id: userId,
                    nama: newNama,
                    username: newUsername,
                    role: newRole,
                    is_active: newIsActive
                },
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        // Tutup modal jika update berhasil
                        jQuery('#editModal').modal('hide');

                        // Bersihkan nilai input dalam modal
                        $('#editId').val('');
                        $('#editNama').val('');
                        $('#editUsername').val('');
                        $('#editRole').val('');
                        $('#editIsActive').val('');

                        // Memuat ulang data tabel setelah operasi selesai
                        loadPenggunaData();

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
            $('#inputNama').val('');
            $('#inputUsername').val('');
            $('#inputRole').val('');
            $('#inputIsActive').val('');
        });

        // Event saat modal tertutup
        jQuery('#editModal').on('hidden.bs.modal', function() {
            // Bersihkan nilai input dalam modal
            $('#editId').val('');
            $('#editNama').val('');
            $('#editUsername').val('');
            $('#editRole').val('');
            $('#editIsActive').val('');
        });

    });
</script>
<?= $this->endSection() ?>