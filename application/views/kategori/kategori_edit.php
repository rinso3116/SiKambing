<form id="form-kategori-edit" action="<?php echo site_url('kategori/kategori_update'); ?>" method="post" autocomplete="off">
    <input type="hidden" name="id_kategori" value="<?php echo $kategori->id_kategori; ?>">
    <div class="modal-body">
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama kategori</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
                value="<?php echo $kategori->nama_kategori; ?>" required>
        </div>

        <div class="mb-3">
            <label for="keterangan_kategori">Keterangan</label>
            <textarea class="form-control" id="keterangan_kategori" name="keterangan_kategori" rows="3"><?php echo $kategori->keterangan_kategori; ?></textarea>
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
        $('#form-kategori-edit').on('submit', function(e) {
            e.preventDefault(); // Prevent form from submitting normally

            // Serialize form data
            var formData = new FormData(this); // 'this' refers to the form element

            // AJAX request
            $.ajax({
                url: '<?= site_url("kategori/kategori_update") ?>', // Change to your form action URL
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    // Jika berhasil
                    toastr.success('kategori berhasil diupdate!', 'Sukses');

                    $('#kategori_modal').modal('hide');
                    $('#table_kategori').DataTable().ajax.reload(); // Memperbarui DataTable
                },
                error: function(xhr, status, error) {
                    // Jika terjadi error
                    toastr.error('Terjadi kesalahan saat update data kategori.', 'Error');
                }
            });
        });
    });
</script>