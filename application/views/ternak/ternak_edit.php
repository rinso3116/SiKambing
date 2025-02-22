<form id="form-ternak-edit" action="<?php echo site_url('ternak/ternak_update'); ?>" method="post" autocomplete="off">
    <input type="hidden" name="id_ternak" value="<?php echo $ternak->id_ternak; ?>">
    <div class="modal-body">
        <div class="col-md-12">
            <?php
            $list_kategori = $this->Model_ternak->list_kategori();
            $cari_ternak_kategori = $this->Model_ternak->single_ternak_kategori($ternak->id_ternak);
            $list_ternak_kategori = $this->Model_ternak->list_ternak_kategori($ternak->id_ternak);
            $daftar_kategori_ternak_ini = array();
            foreach ($list_ternak_kategori as $key) {
                array_push($daftar_kategori_ternak_ini, $key->id_kategori);
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="nama_ternak" class="form-label">Nama Ternak</label>
            <input type="text" class="form-control" id="nama_ternak" name="nama_ternak"
                value="<?php echo $ternak->nama_ternak; ?>" required>
        </div>

        <div class="mb-3">
            <label for="id_kategori">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($list_kategori as $key): ?>
                    <option value="<?= $key->id_kategori; ?>"
                        <?= in_array($key->id_kategori, $daftar_kategori_ternak_ini) ? 'selected' : ''; ?>>
                        <?= $key->nama_kategori; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="Jantan" <?php echo ($ternak->jenis_kelamin == 'Jantan') ? 'selected' : ''; ?>>Jantan</option>
                <option value="Betina" <?php echo ($ternak->jenis_kelamin == 'Betina') ? 'selected' : ''; ?>>Betina</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah"
                value="<?php echo $ternak->jumlah; ?>" required>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Submit form via AJAX
        $('#form-ternak-edit').on('submit', function(e) {
            e.preventDefault(); // Prevent form from submitting normally

            // Serialize form data
            var formData = new FormData(this); // 'this' refers to the form element

            // AJAX request
            $.ajax({
                url: '<?= site_url("ternak/ternak_editsave") ?>', // Change to your form action URL
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    // Jika berhasil
                    toastr.success('ternak berhasil diupdate!', 'Sukses');

                    $('#ternak_modal').modal('hide');
                    $('#table_ternak').DataTable().ajax.reload(); // Memperbarui DataTable
                },
                error: function(xhr, status, error) {
                    // Jika terjadi error
                    toastr.error('Terjadi kesalahan saat update data ternak.', 'Error');
                }
            });
        });
    });
</script>